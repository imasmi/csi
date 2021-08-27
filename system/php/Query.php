<?php
namespace system\php;

class Query{
    public function __construct($PDO, $Core, $database){
        $this->PDO = $PDO;
        $this->Core = $Core;
        $this->db = $database;
    }
    
    public function select($value, $selector="id", $table="module", $fields="*", $delimeter="="){
        $table = ($table === "module") ? $this->table() : $table;
	    return $this->PDO->query("SELECT " . $fields . " FROM " . $table . " WHERE " . $selector . " " .  $delimeter . " '" . $value . "'")->fetch();
	}
	
	public function insert($array, $table="module"){
	    $array = array_filter($array);
	    $names = "";
	    $outputs = "";
	    $table = ($table === "module") ? $this->table() : $table;
	    foreach($array as $key=>$value){
            $names .= $key . ",";
            $outputs .= ":" . $key . ",";
        }
        
	    $insert = $this->PDO->prepare("INSERT INTO " . $table . " (" . rtrim($names, ",") . ") VALUES (" . rtrim($outputs, ",") . ")");
        return $insert->execute($array);
	}
    
    public function update($array, $identifier="-1", $selector="id", $table="module", $delimeter="="){
	    foreach ($array as $i => $value) { if ($value === "") $array[$i] = null;}
        $output = "";
        foreach($array as $key=>$value){
            $output .= "`" . $key . "`=:" . $key . ",";
        }
        $table = ($table === "module") ? $this->table() : $table;
        $update = $this->PDO->prepare("UPDATE " . $table . " SET " . rtrim($output, ",") . " WHERE " . $selector . $delimeter . "'" . $identifier . "'");
        return $update->execute($array);
    }
    
    public function remove($value,  $selector="id", $table="module", $delimeter="="){
	    $table = ($table === "module") ? $this->table() : $table;
	    return $this->PDO->query("DELETE FROM " . $table . " WHERE " . $selector . $delimeter . "'" . $value . "'");
	}
    
    public function loop($query, $table=false){
        if($table === false){
            preg_match('/FROM\s(.*)\sWHERE/', $query, $matches);
    	    $table = trim($matches[1]);
        }
	    global $Page;
	    global $File;
	    global $Text;
	    global $Setting;
	    $array = array($Page->table => array(), $File->table => array(), $Text->table => array(), $Setting->table => array());
	    foreach($this->PDO->query($query, \PDO::FETCH_ASSOC) as $fortable){
	        $array[$table][$fortable["id"]] = $fortable;
	        
	        foreach($array as $subtable => $values){
                if($table != $subtable && $subtable != $Page->table){
                    $hooked = $this->PDO->query("SELECT * FROM " . $subtable . " WHERE fortable='" . $table . "'" . ($table == $Page->table ? " OR fortable IS NULL" : "") .  " AND page_id='" . $fortable["id"] . "'");
                    if($hooked->rowCount() > 0){
                        foreach($hooked as $hook){
                            $array[$subtable] = $array[$subtable] + $this->loop("SELECT * FROM " . $subtable . " WHERE id='" . $hook["id"] . "'", $subtable)[$subtable];
                        }
                    }
                }
            }
            
            if($table == $Page->table || $table == $File->table || $table == $Setting->table){
                $links =  $this->PDO->query("SELECT * FROM " . $table . " WHERE link_id='" . $fortable["id"] . "'");
                if($links->rowCount() > 0){
                    foreach($links as $link){
                        foreach($array as $subtable => $values){
                            $array[$subtable] += $this->loop("SELECT * FROM " . $table . " WHERE id='" . $link["id"] . "'", $table)[$subtable];
                        }
                    }
                }
            }
        }
        return $array;
    }
    
    public function cleanup($value,  $selector="id", $table="module", $delimeter="="){
	    $FileAPP = new \system\module\File\php\FileAPP;
	    $table = ($table === "module") ? $this->table() : $table;
	    
	    foreach($this->loop("SELECT * FROM " . $table . " WHERE " . $selector . $delimeter . "'" . $value . "'") as $table => $values){
	        foreach($values as $id => $field){
	            if($table == $FileAPP->table){
                    $fileDir = $FileAPP->files_dir($field["id"]);
                    if(is_dir($fileDir)){$FileAPP->delete_dir($fileDir);}
                }
                $this->remove($field["id"], "id", $table);
	        }
	    }
    }
    
    public function column_group($column, $table=false){
        $table = ($table === false) ? $this->table() : $table;
        $array = $this->PDO->query("SELECT " . $column . " FROM " . $table . " WHERE " . $column . " IS NOT NULL AND " . $column . " !='' GROUP by " . $column . " ORDER by "  . $column . " ASC" )->fetchAll(\PDO::FETCH_COLUMN);
        return array_combine($array, $array);
    }
    
    public function table($name=false){
        global $Module;
        $name = ($name !== false) ? $name : $Module->_();
        if(strpos($name, $this->db["prefix"] . "_") !== false){
            return $name;
        } else {
            return mb_strtolower($this->db["prefix"] . "_" . $name);
        }
    }
    
    public function new_id($table = false, $field = "id", $where=""){
        $this_table = ($table === false) ? $this->table() : $table;
        $last_file = $this->PDO->query("SELECT " . $field . " FROM " . $this_table . " " . $where . " ORDER by " . $field . " DESC")->fetch();
        return isset($last_file[$field]) ? ++$last_file[$field] : 1;
    }
    
    public function top_id($value, $selector="link_id", $returnField="id", $table=false){
        $this_table = ($table === false) ? $this->table() : $table;
        $top_id = $this->PDO->query("SELECT " . $selector . " FROM " . $this_table . " WHERE " .  $returnField . "='" . $value . "'")->fetch();
        if($top_id[$selector] == 0){
            return $value;
        }else {
            return $this->top_id($top_id[$selector], $selector, $returnField, $table);
        }
    }
}

$Query = new Query($PDO, $Core, $database);
?>
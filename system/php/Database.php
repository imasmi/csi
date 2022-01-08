<?php
namespace system;

class Database{
    //$input as array ["data" => array, "table" => string]
	public static function insert($input, $table="module"){
	    if(isset($input["data"])) {
	        $array = array_filter($input["data"], 'strlen');
	        $table = $input["table"];
	    } else {
	        $array = array_filter($input, 'strlen');
	        $table = ($table === "module") ? static::table() : $table;
	    }
	    
	    $names = "";
	    $outputs = "";
	    
	    foreach($array as $key=>$value){
            $names .= $key . ",";
            $outputs .= ":" . $key . ",";
        }

	    $insert = $GLOBALS["PDO"]->prepare("INSERT INTO " . $table . " (" . rtrim($names, ",") . ") VALUES (" . rtrim($outputs, ",") . ")");
        return $insert->execute($array);
	}

    //$input as array ["data" => array, "table" => string, "where" => string]
    public static function update($input, $identifier="-1", $selector="id", $table="module", $delimeter="="){
        if(isset($input["data"])) {
	        $array = $input["data"];
	        $table = $input["table"];
	        $where = $input["where"];
	    } else {
	        $array = $input;
	        $table = ($table === "module") ? static::table() : $table;
	        $where = $selector . $delimeter . "'" . $identifier . "'";
	    }
        
        $output = "";
        foreach ($array as $i => $value) { if ($value === "") $array[$i] = null;}
        foreach($array as $key=>$value){
            $output .= "`" . $key . "`=:" . $key . ",";
        }
        $table = ($table === "module") ? static::table() : $table;
        $update = $GLOBALS["PDO"]->prepare("UPDATE " . $table . " SET " . rtrim($output, ",") . " WHERE " . $where);
        return $update->execute($array);
    }

    public static function loop($query, $table=false){
        if($table === false){
            preg_match('/FROM\s(.*)\sWHERE/', $query, $matches);
    	    $table = trim($matches[1]);
        }
	    global $Page;
	    global $File;
	    global $Text;
	    global $Setting;
	    $array = array($Page->table => array(), $File->table => array(), $Text->table => array(), $Setting->table => array());
	    foreach($GLOBALS["PDO"]->query($query, \PDO::FETCH_ASSOC) as $fortable){
	        $array[$table][$fortable["id"]] = $fortable;

	        foreach($array as $subtable => $values){
                if($table != $subtable && $subtable != $Page->table){
                    $hooked = $GLOBALS["PDO"]->query("SELECT * FROM " . $subtable . " WHERE fortable='" . $table . "'" . ($table == $Page->table ? " OR fortable IS NULL" : "") .  " AND page_id='" . $fortable["id"] . "'");
                    if($hooked->rowCount() > 0){
                        foreach($hooked as $hook){
                            $array[$subtable] = $array[$subtable] + static::loop("SELECT * FROM " . $subtable . " WHERE id='" . $hook["id"] . "'", $subtable)[$subtable];
                        }
                    }
                }
            }
            
            if($table == $Page->table || $table == $File->table || $table == $Setting->table || $table == $Text->table){
                $links =  $GLOBALS["PDO"]->query("SELECT * FROM " . $table . " WHERE link_id='" . $fortable["id"] . "'");
                if($links->rowCount() > 0){
                    foreach($links as $link){
                        foreach($array as $subtable => $values){
                            $array[$subtable] += static::loop("SELECT * FROM " . $table . " WHERE id='" . $link["id"] . "'", $table)[$subtable];
                        }
                    }
                }
            }
        }
        return $array;
    }

    //$input as array ["query" => string]
    public static function cleanup($input,  $selector="id", $table="module", $delimeter="="){
        require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
        $FileAPP = new \module\File\FileAPP;
        
        if(isset($input["query"])) {
            $query = $input["query"];
	    } else {
	        $table = ($table === "module") ? static::table() : $table;
	        $query = "SELECT * FROM " . $table . " WHERE " . $selector . $delimeter . "'" . $input . "'";
	    }
        
        
	    $table = ($table === "module") ? static::table() : $table;

	    foreach(static::loop($query) as $table => $values){
	        foreach($values as $id => $field){
	            if($table == $FileAPP->table){
                    $fileDir = $FileAPP->files_dir($field["id"]);
                    if(is_dir($fileDir)){$FileAPP->delete_dir($fileDir);}
                }
                $GLOBALS["PDO"]->query("DELETE FROM " . $table . " WHERE id='" . $field["id"] . "'");
	        }
	    }
    }

    public static function column_group($column, $table=false){
        $table = ($table === false) ? static::table() : $table;
        $array = $GLOBALS["PDO"]->query("SELECT `" . $column . "` FROM " . $table . " WHERE `" . $column . "` IS NOT NULL AND `" . $column . "` !='' GROUP by `" . $column . "` ORDER by `"  . $column . "` ASC" )->fetchAll(\PDO::FETCH_COLUMN);
        return array_combine($array, $array);
    }

    public static function table($name=false){
        global $Module;
        $name = ($name !== false) ? $name : \system\Module::_($GLOBALS["modules"]);
        if(strpos($name, $GLOBALS["database"]["prefix"] . "_") !== false){
            return $name;
        } else {
            return mb_strtolower($GLOBALS["database"]["prefix"] . "_" . $name);
        }
    }
    
    //$input as array ["query" => string, "column" => string]
    public static function new_id($table = false, $field = "id", $where=""){
        if(is_array($table)) {
            $query = $table["query"];
            $column = $table["column"];
        } else {
            $this_table = ($table === false) ? static::table() : $table;
            $query = "SELECT " . $field . " FROM " . $this_table . " " . $where . " ORDER by " . $field . " DESC";
            $column = $field;
        }
        $last_file = $GLOBALS["PDO"]->query($query)->fetch();
        return isset($last_file[$column]) ? ++$last_file[$column] : 1;
    }
    
    //$input as array ["column" => string, "value" => string, "select" => string, "table" => string]
    public static function top_id($value, $selector="link_id", $returnField="id", $table=false){
        if(is_array($value)) {
	        $value = $value["value"];
	        $selector = $value["select"] ? $value["select"] : "link_id";
	        $this_table = $value["table"] ? $value["table"] : static::table();
	        $returnField = $value["column"] ? $value["column"] : "id";
	    } else {
	        $this_table = ($table === false) ? static::table() : $table;
	    }
        
        $top_id = $GLOBALS["PDO"]->query("SELECT " . $selector . " FROM " . $this_table . " WHERE " .  $returnField . "='" . $value . "'")->fetch();
        if($top_id[$selector] == 0){
            return $value;
        }else {
            return static::top_id($top_id[$selector], $selector, $returnField, $table);
        }
    }
}
?>

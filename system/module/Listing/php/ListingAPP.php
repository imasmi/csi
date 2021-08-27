<?php
namespace system\module\Listing\php;

use system\module\Setting\php\Setting as Setting;


class ListingAPP{
    //"row-query" => string (only selector part of the query for the reordering. Must be specified to enable row reordering),
    // Array possible values: "row-order" => ASC|DESC (order by row column, ASC is default)
    // example for array ("row-order" => "ASC", "row-query" => "type='category' AND link_id='18'")
    public function __construct($array = false){
        global $database;
        $this->db = $database;
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $Info;
        $this->Info = $Info;
        global $Language;
        $this->Language = $Language;
        global $User;
        $this->User = $User;
        global $Page;
        $this->Page = $Page;
        global $Text;
        $this->Text = $Text;
        global $File;
        $this->File = $File;
        global $Setting;
        $this->Setting = $Setting;
        $this->arr = $array;
        $this->reorder = isset($array["row-query"]) ? true : false; 
        $this->eval_use_namespace = "use \system\module\File\php\File as File; use \system\module\Setting\php\Setting as Setting; use \system\module\Text\php\Text as Text;";
    }
    
    public function actions(){
        $dir = $this->Core->this_path(0,-1);
        $array = array(
            "add" => $dir . "/add",
            "view" => $dir . "/view",
            "edit" => $dir . "/edit",
            "delete" => $dir . "/delete"
        );
        return $array;
    }
    
    public function view($value, $array="*", $selector="id", $table="module", $delimeter="="){
        $table = ($table === "module") ? $this->Query->table() : $table;
        
        $fields = ($array === "*") ? $array : implode(",", $array);
        $select = $this->Query->select($value, $selector, $table, $fields, $delimeter="=");
        
        if($array === "*"){$array = $this->PDO->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= '" . $this->db["database"] . "' AND TABLE_NAME = '" . $table . "'")->fetchALL(\PDO::FETCH_COLUMN);}
        ?>
        
        <table>
            <?php foreach($array as $key){ ?>
            <tr>
                <th><?php echo ucfirst($key);?></th>
                <td><?php echo $select[$key]?></td>
            </tr>
            <?php } ?>
        </table>
    <?php }

// Listing functions for queries and arrays
    public function page(){
        $p = isset($_GET["p"]) ? $_GET["p"] : 1;
        $pp = isset($_GET["pp"]) ? $_GET["pp"] : 20;
        return array(
            "p" => $p,
            "pp" => $pp,
            "start" => ($p - 1) * $pp
        );
    }
    
    public function page_slice($array = array()){
        $page = $this->page();
        return array_slice($array, $page["start"], $page["pp"], true);
    }
    
    public function pagination($rows){
        $page = $this->page();
        $p = $page["p"];
        $pp = $page["pp"];
        $pages = ceil($rows/$pp);
        $start_page = ($p > 5) ? $p - 3 :  1;
        $end_page = ($p < ($pages - 5)) ? $p + 3 : $pages;
        ?>
        <ul class="pagination">
            <?php
            if($p > 5){
                for($a = 1; $a <= 3; $a++){
                    echo "<li class='pagination-p'><a class='button' href='" . $this->replace_get(array("p" => $a)) . "'>" . $a . "</a></li>";
                }
                echo ' ';
            }
            
            for($a = $start_page; $a <= $end_page; $a++){
                $selected_page = ($a == $p) ? ' selectedPage' : "";
                echo "<li class='pagination-p'><a class='button" . $selected_page . "' href='" . $this->replace_get(array("p" => $a)) . "'>" . $a . "</a></li>";
            }
            
            if($p < ($pages - 5)){
                echo ' ';
                for($a = $pages - 2; $a <= $pages; $a++){
                    echo "<li class='pagination-p'><a class='button' href='" . $this->replace_get(array("p" => $a)) . "'>" . $a . "</a></li>";
                }
            }
            
            
            $per_values = array("20", "40", "100", "200", "500", "1000", "2000", "5000");
            $pp = isset($_GET["pp"]) ? $_GET["pp"] : "20";
            ?>
            
            <li class="pagination-pp">
                <select onchange="window.open( this.value,'_self')">
                    <?php foreach($per_values as $perPage){
                    $selected = ($perPage == $pp) ? " selected" : "";
                    ?>
                    <option value='<?php echo $this->replace_get(array("p" => 1, "pp" => $perPage));?>' <?php echo $selected;?>><?php echo $perPage;?></option>
                    <?php }?>
                </select>
            </li>
            <li class="pagination-sum"><?php echo $this->Text->item("Total pages") . ' ' . $pages;?></li>
        </ul>
        <?php
    }
    
    public function _($array="*", $actions="*", $table="module", $query=""){
        $table = ($table === "module") ? $this->Query->table() : $table;
        if($array === "*"){$array = $this->PDO->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= '" . $this->db["database"] . "' AND TABLE_NAME = '" . $table . "'")->fetchALL(\PDO::FETCH_COLUMN);}
        if($actions === "*"){$actions = $this->actions();}
        ?>
        <div class="inline-block">
            <?php 
            foreach($actions as $key => $action){
                if($key == "add" || mb_substr($key, 0, 1) == "*"){
                $txt = (mb_substr($key, 0, 1) == "*") ? ltrim($key, "*") : $key;
                ?>
                <button type="button" class="button" onclick="window.open('<?php echo $actions[$key];?>', '_self')"><?php echo ucfirst($this->Text->item($txt));?></button>
                <?php 
                unset($actions[$key]);
                } 
            }
            ?>
            
            <form method="get" class="right">
                <?php foreach ($_GET as $key => $value) { if($key != "url"){?> <input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>"/> <?php }}?>
                <input type="text" name="search" value="<?php if(isset($_GET["search"])){ echo $_GET["search"];}?>" required/>
                <button class="button"><?php echo $this->Text->item("Search");?></button>
            </form>
        </div>
        
        <table class="listing<?php if($this->reorder){ echo ' border-collapse';}?>" cellspacing="0px">
            <tr>
                <th>#</th>
                <?php 
                if(is_array($array)){
                foreach($array as $key=>$value){
                ?>
                <th><?php if(is_int($key)){ echo ucfirst($value);} else {echo ucfirst($key);}?></th>
                <?php }
                }
                ?>
                
                <?php 
                foreach($actions as $key=>$value){
                ?>
                <th><?php echo ucfirst($key);?></th>
                <?php }
                ?>
            </tr>
            
            <?php
            $output = "";
            $cnt = 1;
			
			$output = array();
            if(is_array($array)){
            foreach($array as $key=>$value){
                if(is_array($value)){$output[] = key($value);} else { $output[] = $value;}
            $cnt++;
            }}
            $output[] = "id"; // Add ID to be always in selected columns
            $output = in_array("*", $output) ? "*" :  implode(",", array_unique($output));
            
            
            $page = $this->page();
            $p = $page["p"];
            $pp = $page["pp"];
            $cnt = (($p - 1) * $pp) + 1;
            $query = (strpos($query, "SELECT") !== false) ? $query :  "SELECT " . $output . " FROM " . $table . " " . $query;
            
            $list_all_selected = $this->PDO->query($query);
            if(isset($_GET["search"]) && !empty($_GET["search"])){
                $lists = array();
                foreach($list_all_selected as $list){
                    ob_start();
                    foreach($array as $key=>$value){
                        if(is_array($value)){ eval($this->eval_use_namespace . $value[key($value)]);} else { echo $list[$value];}
                    }
                    $searchResult = ob_get_contents();
                    ob_end_clean();
                    if(strpos(mb_strtolower($searchResult, "UTF-8"), mb_strtolower($_GET["search"], "UTF-8")) !== false){$lists[$list["id"]] = $list;}
                }
                $rows = count($lists);
            } else {
                $lists = $this->PDO->query($query . " LIMIT " . (($p - 1) * $pp ) . "," . $pp);
                $rows = $list_all_selected->rowCount();
            }
            
            foreach($lists as $list){
            ?>
            <tr id="row-<?php echo $list["id"];?>" class="listing-row" <?php if($this->reorder){?> data-table="<?php echo $table;?>" data-row-order="<?php echo $this->arr["row-order"];?>" data-row-query="<?php echo $this->arr["row-query"];?>" <?php } ?>>
                <th><?php echo $cnt;?></th>
               <?php 
               foreach($array as $key=>$value){
                ?>
                <td <?php if($this->reorder){?>onmousedown="ListingAPP.drag('#row-<?php echo $list["id"];?>')" onmouseup="ListingAPP.stopDrag()"<?php } ?>><?php echo $this->listing_view($list, $value);?></td>
                <?php
                } ?>
                
                <?php 
                foreach($actions as $key=>$value){ 
                    
                ?>
                    <td>
                    <?php
                    if(!is_array($value) || key($value) === "url"){
                    ?>
                       <button type="button" class="button" onclick="window.open('<?php if(!is_array($value)){ if($value == "url"){ echo $this->Page->url($list["id"]);} else {echo ( $value . (strpos($value, "?") === false ? '?id' : "") . "=" . $list["id"]);}} else {echo $this->Page->url($value["url"]);} ?>', '_self')"><?php echo $this->Text->item(ucfirst($key));?></button>
                    <?php 
                        } else {
                            eval($this->eval_use_namespace . $value[key($value)]);
                        }
                    ?>
                    </td>
                <?php }?>
            </tr>
            <?php 
            $cnt++;
            } ?>
        </table>
        <?php
        $this->pagination($rows);
    }
    
    
    public function replace_get($array){
        $get = $_GET;
        foreach($array as $key => $value){
            $get[$key] = $value;
        }
        
        $cnt = 0;
        $output = $this->Core->url();
        foreach($get as $key => $value){
            if($cnt == 0){
                $output .= $value;
            } elseif($cnt == 1){
                $output .= "?" . $key . "=" . $value;
            } else {
                $output .= "&" . $key . "=" . $value;
            }
        $cnt++;
        }
        return $output;
    }
    
    private function listing_view($list, $value){
        if(is_array($value)){
            ob_start();
            eval($this->eval_use_namespace . $value[key($value)]);
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = strip_tags($list[$value]);
        }
        
        $list_explode = explode(" ", $output);
        if(strip_tags($output) != $output){
            $view = $output;
        } elseif(isset($_GET["search"]) && $_GET["search"] != ""){
            if($this->User->_() != "admin"){ require_once($this->Core->doc_root() . "/system/module/Text/php/TextAPP.php");}
            $TextAPP = new \system\module\Text\php\TextAPP;
            $view = $TextAPP->slice($output, array("search"=> $_GET["search"], "start" => -2, "length" => 5));
        } elseif(count($list_explode) < 3){
            $view = $output;
        }  else {
            $view = implode(" ", array_slice( $list_explode, 0, 4)) . '...';
        }
        return $view;
    }
}
?>
<?php
$PageAPP = new \module\Page\PageAPP;
$FileAPP = new system\module\File\FileAPP;
$CodeAPP = new \module\Code\CodeAPP;
$check = array();
$select = $PDO->query("SELECT * FROM " . $Page->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
if($CodeAPP->special_characters_check($_POST["filename"]) === true){$check["#filename"] = "Special characters are not allowed.";}

foreach($Language->items as $value){
    if($CodeAPP->special_characters_check($_POST[$value]) === true){
        $check["#" . $value] = "Special characters are not allowed.";
    }
}

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    $_POST["filename"] = $PageAPP->url_format($_POST["filename"]);
    if($select["menu"] != $_POST["menu"]){ $_POST["row"] = \system\Database::new_id($Page->table, "row", " WHERE menu='" . $_POST["menu"] . "'");}
    
    if($_POST["homepage"] == "on"){
        $PDO->query("UPDATE " . \system\Database::table() . " SET `type`='' WHERE `type`='homepage'");
        unset($_POST["homepage"]);
        $_POST["type"] = "homepage";
    }
    
    foreach($Language->items as $key=>$value){
        $_POST[$value] = (strpos($_POST[$value], "http") !== false) ? $_POST[$value] : $PageAPP->url_format($_POST[$value]);
    }
    
    $update = \system\Database::update($_POST, $_GET["id"]);
    
    if($update){
        #ADD FILE IF NOT EXISTS
        if($_POST["filename"] != ""){
            $dir = $Page->doc_root . $Page->path($_GET["id"], true);
            if($select["filename"] === ""){
                if(!is_dir($dir)){ mkdir($dir, 0755, true);}
                file_put_contents($dir . '/' . $_POST["filename"] . ".php", "");
            } elseif($select["filename"] != $_POST["filename"]){
                #RENAME FILE IF FILENAME IS CHANGED
                $old_name = $Page->doc_root . implode("/", $Page->path($id, array("column" => "filename"))) . ".php";
                $new_name = $Page->doc_root . $Page->path($id, true) . "/" . $name . ".php";
                if(file_exists($old_name)){rename($old_name, $new_name);}
                
                echo $PageAPP->rename_file($_GET["id"], $_POST["filename"]);
                #RENAME FILE SUB DIR IF EXISTS
                $sub_dir = $dir . '/' . $select["filename"];
                if(is_dir($sub_dir)){ rename($sub_dir, $dir . '/' . $_POST["filename"]);}
            }
        } else {
            if(file_exists($Page->doc_root . $Page->path($id) . ".php")){unlink($Page->doc_root . $Page->path($id) . ".php");}
        }
        ?><script>history.go(-1)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
    \system\Form::validate($check);
}
exit;
?>
<?php
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP($_GET["id"]);
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($_GET["id"]);
require_once(\system\Core::doc_root() . "/system/module/Code/php/CodeAPP.php");
$CodeAPP = new \module\Code\CodeAPP;
$check = array();
$select = $PDO->query("SELECT * FROM " . $Page->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
$page_path = $Page->path($_GET["id"]);
if($CodeAPP->special_characters_check($_POST["filename"]) === true){$check["#filename"] = "Special characters are not allowed.";}

foreach($Language->items as $value){
    if($CodeAPP->special_characters_check($_POST[$value]) === true){
        $check["#" . $value] = "Special characters are not allowed.";
    }
}

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    #EDIT PAGE
    $array = array(
            "tag" => $_POST["tag"],
            "menu" => $_POST["menu"],
            "filename" => $PageAPP->url_format($_POST["filename"])
    );
    
    if($select["menu"] != $_POST["menu"]){ $array["row"] = \system\Database::new_id($Page->table, "row", " WHERE menu='" . $_POST["menu"] . "'");}
    
    if(isset($_POST["homepage"]) && $_POST["homepage"] == "on"){
        $PDO->query("UPDATE " . \system\Database::table() . " SET `type`='' WHERE `type`='homepage'");
        $array["type"] = "homepage";
    }
    
    foreach($Language->items as $key=>$value){
        $array[$value] = (strpos($_POST[$value], "http") !== false) ? $_POST[$value] : $PageAPP->url_format($_POST[$value]);
    }
    
    $update = \system\Database::update($array, $_GET["id"]);
    
    if($update){
        #ADD FILE IF NOT EXISTS
        if($_POST["filename"] != ""){
            $dir = $Page->doc_root . $Page->path($_GET["id"], true);
            if($select["filename"] === ""){
                if(!is_dir($dir)){ mkdir($dir, 0755, true);}
                file_put_contents($dir . '/' . $_POST["filename"] . ".php", "");
            } elseif($select["filename"] != $_POST["filename"]){
                #RENAME FILE IF FILENAME IS CHANGED
                $old_name = $Page->doc_root . '/' . $page_path . ".php";
                $new_name = $Page->doc_root . '/' . $Page->path($_GET["id"], true) . $_POST["filename"] . ".php";
                if(file_exists($old_name)){rename($old_name, $new_name);}
                
                #RENAME FILE SUB DIR IF EXISTS
                $sub_dir = $dir . '/' . $select["filename"];
                if(is_dir($sub_dir)){ rename($sub_dir, $dir . '/' . $_POST["filename"]);}
            }
        } else {
            if(file_exists($Page->doc_root . $Page->path($_GET["id"]) . ".php")){unlink($Page->doc_root . $Page->path($_GET["id"]) . ".php");}
        }
        
        $posts = array();
        foreach($Language->items as $key=>$value){
            $posts["Title_" . $value] = $_POST["Title_" . $value]; 
            $posts["Menu_" . $value] = $_POST["Menu_" . $value]; 
            $posts["Description_" . $value] = $_POST["Description_" . $value]; 
        }
        require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");
        $SettingAPP = new \module\Setting\SettingAPP($_GET["id"]);
        $SettingAPP->save($posts);
        $FileAPP->upload();
        $FileAPP->upload_edit();
        ?><script>history.go(-1)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
    \system\Form::validate($check);
}
exit;
?>
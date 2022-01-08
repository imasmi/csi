<?php
$Object = $Plugin->object();
$select = $PDO->query("SELECT * FROM " . $Page->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;
require_once(\system\Core::doc_root() . "/system/module/Code/php/CodeAPP.php");
$CodeAPP = new \module\Code\CodeAPP;
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($_GET["id"], array("plugin" => $Object->plugin));
require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");

$check = array();
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
    $data = array(
            "type" => $_POST["type"],
            "link_id" => $_POST["link_id"],
            "menu" => $_POST["menu"]
    );
    if($select["link_id"] != $_POST["link_id"]){ $data["row"] = $PDO->query("SELECT row FROM " . $Page->table . " WHERE link_id='" . $_POST["link_id"] . "'")->fetch()["row"] += 1;}
    foreach($Language->items as $key=>$value){
        $data[$value] = (strpos($_POST[$value], "http") !== false) ? $_POST[$value] : $PageAPP->url_format($_POST[$value]);
    }
    $update = \system\Database::update(["data" => $data, "table" => $Object->table, "where" => "id='" . $_GET["id"] . "'"]);
    
    if($update){
        $posts = array();
        foreach($Language->items as $key=>$value){
            $posts["Title_" . $value] = $_POST["Title_" . $value]; 
            $posts["Menu_" . $value] = $_POST["Menu_" . $value]; 
            $posts["Description_" . $value] = $_POST["Description_" . $value]; 
        }
        $SettingAPP = new \module\Setting\SettingAPP($_GET["id"], array("plugin" => $Object->plugin));
        $SettingAPP->save($posts);
        $FileAPP->upload();
        $FileAPP->upload_edit();
        ?><script>history.go(-2)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    $Form = new \system\Form;
    \system\Form::validate($check);
}
exit;
?>
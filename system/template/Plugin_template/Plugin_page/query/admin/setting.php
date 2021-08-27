<?php
$Object = $Plugin->object();
$select = $Query->select($_GET["id"], "id", $Object->table);
$PageAPP = new \system\module\Page\php\PageAPP($_GET["id"]);
$FileAPP = new system\module\File\php\FileAPP($_GET["id"], array("plugin" => $Object->plugin));
$CodeAPP = new \system\module\Code\php\CodeAPP;
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
    $array = array(
            "type" => $_POST["type"],
            "link_id" => $_POST["link_id"],
            "menu" => $_POST["menu"]
    );
    if($select["link_id"] != $_POST["link_id"]){ $array["row"] = $Query->new_id($Page->table, "row", " WHERE link_id='" . $_POST["link_id"] . "'");}
    foreach($Language->items as $key=>$value){
        $array[$value] = (strpos($_POST[$value], "http") !== false) ? $_POST[$value] : $PageAPP->url_format($_POST[$value]);
    }
    $update = $Query->update($array, $_GET["id"], "id", $Object->table);
    
    if($update){
        $posts = array();
        foreach($Language->items as $key=>$value){
            $posts["Title_" . $value] = $_POST["Title_" . $value]; 
            $posts["Menu_" . $value] = $_POST["Menu_" . $value]; 
            $posts["Description_" . $value] = $_POST["Description_" . $value]; 
        }
        $SettingAPP = new \system\module\Setting\php\SettingAPP($_GET["id"], array("plugin" => $Object->plugin));
        $SettingAPP->save($posts);
        $FileAPP->upload();
        $FileAPP->upload_edit();
        ?><script>history.go(-2)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
    $Form->validate($check);
}
exit;
?>
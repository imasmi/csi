<?php
$User->control();
$check = array();
$check_user = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "' AND page_id='" . $User->id . "' AND link_id='0' AND fortable='" . $User->table . "'");
if($check_user->rowCount() != 1){ $check["#address"] = $Text->_("Error");}

if(empty($check)){

    require_once($Core->doc_root() . '/system/module/Setting/php/SettingAPP.php');
    $SettingAPP = new \system\module\Setting\php\SettingAPP($User->id, array("fortable" => $User->table));
    
    $array = array(
        "value" => isset($_POST["default"]) ? "default" : ""
    );
    $Query->update($array, $_GET["id"], "id", $Setting->table);
    
    if(isset($_POST["default"])){
        foreach($PDO->query("SELECT * FROM " . $Setting->table . " WHERE `fortable` = '" . $User->table . "' AND page_id='" . $User->_("id") . "' AND link_id='0' AND tag='address'") as $setting){
            $Query->update(array("value" => $_GET["id"] == $setting["id"] ? "default" : ""), $setting["id"], "id", $Setting->table);
        }
    }
    
    unset($_POST["default"]);
    $fields = $_POST;
    $fields["page_id"] = $User->id;
    $fields["link_id"] = $_GET["id"];
    $SettingAPP->save($fields);
    ?><script>history.go(-1)</script><?php

} else {
    $Form->validate($check);
}
?>
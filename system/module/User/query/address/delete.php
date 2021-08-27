<?php
$User->control();
$check = array();
$check_user = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "' AND page_id='" . $User->id . "' AND link_id='0' AND fortable='" . $User->table . "'");
if($check_user->rowCount() != 1){ $check["#address"] = $Text->_("Error");}

if(empty($check)){
    require_once($Core->doc_root() . '/system/module/Setting/php/SettingAPP.php');
    $SettingAPP = new \system\module\Setting\php\SettingAPP($User->id, array("fortable" => $User->table));
    $SettingAPP->remove($_GET["id"]);
    ?><script>history.go(-2)</script><?php
} else {
    $Form->validate($check);
}

?>
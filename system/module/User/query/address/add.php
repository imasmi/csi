<?php
$User->control();
require_once($Core->doc_root() . '/system/module/Setting/php/SettingAPP.php');
$SettingAPP = new \system\module\Setting\php\SettingAPP($User->id, array("fortable" => $User->table));

if(isset($_POST["default"])){
    foreach($PDO->query("SELECT * FROM " . $Setting->table . " WHERE `fortable` = '" . $User->table . "' AND page_id='" . $User->_("id") . "' AND link_id='0' AND tag='address'") as $setting){
        $Query->update(array("value" => ""), $setting["id"], "id", $Setting->table);
    }
}

$array = array(
    "page_id" => $User->id,
    "link_id" => "0",
    "fortable" => $User->table,
    "tag" => "address",
    "value" => isset($_POST["default"]) ? "default" : ""
);

$Query->insert($array, $Setting->table);
$link_id = $PDO->lastInsertId();



unset($_POST["default"]);
$fields = $_POST;
$fields["page_id"] = $User->id;
$fields["link_id"] = $link_id;
$SettingAPP->save($fields);
?><script>history.back()</script><?php
?>
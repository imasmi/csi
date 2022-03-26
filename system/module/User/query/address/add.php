<?php
$User->control();
require_once(\system\Core::doc_root() . '/system/module/Setting/php/SettingAPP.php');
$SettingAPP = new \module\Setting\SettingAPP($User->id, array("fortable" => $User->table));

if(isset($_POST["default"])){
    \system\Data::update(["data" => ["value" => null], "table" => $Setting->table, "where" => "`fortable` = '" . $User->table . "' AND page_id='" . $User->id . "' AND link_id='0' AND tag='address' AND `type`='default'"]);
}

$data = [
    "page_id" => $User->id,
    "link_id" => "0",
    "user_id" => $User->id,
    "fortable" => $User->table,
    "tag" => "address",
    "type" => isset($_POST["default"]) ? "default" : ""
];

\system\Data::insert(["data" => $data, "table" => $Setting->table]);
$link_id = $PDO->lastInsertId();



unset($_POST["default"]);
$fields = $_POST;
$fields["page_id"] = $User->id;
$fields["link_id"] = $link_id;
$SettingAPP->save($fields);
?><script>history.back()</script><?php
?>
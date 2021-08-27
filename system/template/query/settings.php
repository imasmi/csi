<?php
$SettingAPP = new \system\module\Setting\php\SettingAPP($_GET["id"]);
$FileAPP = new system\module\File\php\FileAPP($_GET["id"]);
$SettingAPP->save($_POST);
$FileAPP->upload(array("page_id" => $_GET["id"]));
$FileAPP->upload_edit();
?>
<script>history.go(-2)</script>
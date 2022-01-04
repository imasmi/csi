<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP;
require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");
$SettingAPP = new \module\Setting\SettingAPP(0);
$SettingAPP->save($_POST);

$FileAPP->upload();
$FileAPP->upload_edit();

?><script>history.go(-1)</script><?php
?>
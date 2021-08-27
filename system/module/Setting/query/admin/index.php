<?php
$FileAPP = new system\module\File\php\FileAPP;
$SettingAPP = new \system\module\Setting\php\SettingAPP(0);
$SettingAPP->save($_POST);

$FileAPP->upload();
$FileAPP->upload_edit();

?><script>history.go(-1)</script><?php
?>
<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new module\File\FileAPP;
$FileAPP->input_form($_GET["id"], $_GET["path"], $_POST);
?>

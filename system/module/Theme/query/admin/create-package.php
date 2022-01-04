<?php
include_once(\system\Core::doc_root() . "/system/php/Ini.php");
include_once(\system\Core::doc_root() . "/system/module/File/php/ZipAPP.php");
include_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP;
$Theme->package($_POST["name"], ["download" => true]);
?>
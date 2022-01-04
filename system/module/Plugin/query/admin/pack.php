<?php
$file = \system\Core::doc_root() . "/plugin/" . $_GET["plugin"] . "/" . $_GET["plugin"] . '.zip';
require_once(\system\Core::doc_root() . "/system/module/File/php/ZipAPP.php");
$ZipAPP = new \module\File\ZipAPP($file, \system\Core::doc_root() . "/plugin/" . $_GET["plugin"], array("exclude" => \system\Core::doc_root() . "/plugin/" . $_GET["plugin"] . "/ini"));
if($ZipAPP->create()){
    header('Content-type:  application/zip');
    header('Content-Length: ' . filesize($file));
    header('Content-Disposition: attachment; filename="' . $_GET["plugin"] . '.zip"');
    readfile($file);
    ignore_user_abort(true);
    unlink($file);
}
?>
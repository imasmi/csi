<?php
$backup = $_GET["path"] . '/' . basename($_GET["path"]) . ".zip";
$ZipAPP = new \module\File\ZipAPP($backup, $_GET["path"]);
$ZipAPP->create();

header("Content-type: application/zip"); 
header("Content-Disposition: attachment; filename=" . basename($backup));
header("Content-length: " . filesize($backup));
header("Pragma: no-cache"); 
header("Expires: 0"); 

readfile($backup);
unlink($backup);
?>
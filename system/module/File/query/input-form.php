<?php 
if($User->role != "admin"){ require_once($Core->doc_root() . "/system/module/File/php/FileAPP.php");}
$FileAPP = new system\module\File\php\FileAPP;
$FileAPP->input_form($_GET["id"], $_GET["path"], $_POST);
?>
<?php
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP;
$path = $Page->path($_GET["id"]);
$dir = $Page->doc_root . '/' . $path;
$file = $dir . ".php";

if(count($Page->scheme($_GET["id"])) == count(explode("/", $path)) && file_exists($file)){
    unlink($file);
    if(is_dir($dir)){$FileAPP->delete_dir($dir);}
}
\system\Database::cleanup($_GET["id"]);
#GO BACK
?><script>history.go(-2)</script><?php
?>
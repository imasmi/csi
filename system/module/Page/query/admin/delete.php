<?php
$PageAPP = new \system\module\Page\php\PageAPP;
$FileAPP = new system\module\File\php\FileAPP;
$path = $Page->path($_GET["id"]);
$dir = $Page->doc_root . '/' . $path;
$file = $dir . ".php";

if(count($Page->scheme($_GET["id"])) == count(explode("/", $path)) && file_exists($file)){
    unlink($file);
    if(is_dir($dir)){$FileAPP->delete_dir($dir);}
}
$Query->cleanup($_GET["id"]);
#GO BACK
?><script>history.go(-2)</script><?php
?>
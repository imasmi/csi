<?php
$FileAPP = new \system\module\File\php\FileAPP;
$FileAPP->delete_dir($_GET["path"]);
$parent = dirname($_GET["path"]);
if(count(scandir($parent)) < 3){rmdir($parent);}
?>
<script>history.back();</script>
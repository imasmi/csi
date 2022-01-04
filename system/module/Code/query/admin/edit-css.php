<?php
require_once(\system\Core::doc_root() . "/system/module/Code/php/CodeAPP.php");
$Code = new \module\Code\CodeAPP;
$Code->edit_css($_GET["selector"], $_POST);
?>

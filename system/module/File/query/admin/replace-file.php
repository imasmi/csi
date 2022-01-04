<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
if(isset($_GET["id"]) && isset($_POST["link_id_" . $_GET["id"]]) && $_POST["link_id_" . $_GET["id"]] == 0){unset($_POST["link_id_" . $_GET["id"]]);}

$FileAPP = new \module\File\FileAPP;
$FileAPP->upload_edit();

if($_POST["method"] == "post"){
    ?><script>history.go(-1)</script><?php
} else {
    echo '<script>history.go(-2)</script>';
}

?>

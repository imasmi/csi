<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($file["page_id"]);
$select = $PDO->query("SELECT * FROM " . $File->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
foreach($PDO->query("SELECT id, path FROM " . \system\Database::table() . " WHERE link_id='" . $_GET["id"] . "'") as $file){
    $PDO->query("DELETE FROM " . $File->table . " WHERE id='" . $file["id"] . "'");
}

if($select["type"] == "gallery" && is_dir($FileAPP->files_dir($_GET["id"]))){
    $FileAPP->delete_dir($FileAPP->files_dir($_GET["id"]));
}

$PDO->query("DELETE FROM " . $File->table . " WHERE id='" . $_GET["id"] . "'");

#GO TO HOMEPAGE
?><script>history.go(-2)</script><?php
?>

<?php
$FileAPP = new system\module\File\php\FileAPP;
$select = $Query->select($_GET["id"]);
foreach($PDO->query("SELECT id, path FROM " . $Query->table() . " WHERE link_id='" . $_GET["id"] . "'") as $file){
    $Query->remove($file["id"]);
}

if($select["type"] == "gallery" && is_dir($FileAPP->files_dir($_GET["id"]))){
    $FileAPP->delete_dir($FileAPP->files_dir($_GET["id"]));
}


$Query->remove($_GET["id"]);

#GO TO HOMEPAGE
?><script>history.go(-2)</script><?php
?>
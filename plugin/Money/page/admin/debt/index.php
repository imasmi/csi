<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$dir = \system\Core::this_path(0,-1);

$array = [
    "Име" => "type"
];

$add_link = isset($_GET["id"]) ? "/add?id=" . $_GET["id"] : "/add";

$actions = array(
    "add" => $dir . $add_link,
    "Описания" => $dir . "/index",
    "Редакция" => $dir . "/edit",
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \module\Listing\ListingAPP; 
        $link_id = isset($_GET["id"]) ? $_GET["id"] : 0;
        $ListingAPP->_($array, $actions, $Setting->table, "WHERE fortable='debt' AND link_id='" . $link_id . "' ORDER by row ASC");
    ?>
</div>
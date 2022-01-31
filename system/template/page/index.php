<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$dir = \system\Core::this_path(0,-1);

$actions = array(
    "add" => $dir . "/add",
    "admin" => "url",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \module\Listing\ListingAPP; 
        $ListingAPP->_("*", $actions, "module", "WHERE id != 0");
    ?>
</div>
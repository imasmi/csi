<?php
$Object = $Plugin->object();
$dir = \system\Core::this_path(0,-1);

$actions = array(
    "add" => $dir . "/add",
    "view" => $dir . "/view",
    "edit" => $dir . "/edit",
    "delete" => \system\Core::url() . "Setting/admin/delete"
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \module\Listing\ListingAPP; 
        $ListingAPP->_("*", $actions, $Object->table, "WHERE `tag` = '" . $Object->tag . "' ORDER by `row` ASC");
    ?>
</div>
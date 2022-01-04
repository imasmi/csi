<?php
$Object = $Plugin->object();
$dir = \system\Core::this_path(0,-1);

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit",
    "setting" => $dir . "/setting",
    "delete" => \system\Core::url() . "Setting/admin/delete"
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \module\Listing\ListingAPP(array("row-order" => "ASC", "row-query" => "`tag`='" . $Object->tag . "' AND plugin='" . $Object->plugin . "'")); 
        $ListingAPP->_("*", $actions, $Object->table, "WHERE `tag` = '" . $Object->tag . "' AND plugin='" . $Object->plugin . "'");
    ?>
</div>
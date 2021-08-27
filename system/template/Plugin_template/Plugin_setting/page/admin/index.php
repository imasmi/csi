<?php
$Object = $Plugin->object();
$dir = $Core->this_path(0,-1);

$actions = array(
    "add" => $dir . "/add",
    "admin" => $dir . "/view",
    "edit" => $dir . "/edit",
    "delete" => $Core->url() . "Setting/admin/delete"
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \system\module\Listing\php\ListingAPP(array("row-order" => "ASC", "row-query" => "`tag`='" . $Object->tag . "' AND plugin='" . $Object->plugin . "'")); 
        $ListingAPP->_("*", $actions, $Object->table, "WHERE `tag` = '" . $Object->tag . "' AND plugin='" . $Object->plugin . "'");
    ?>
</div>
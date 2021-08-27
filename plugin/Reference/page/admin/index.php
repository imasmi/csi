<?php
$Object = $Plugin->object();
$dir = $Core->this_path(0,-1);

$actions = array(
    "add" => $dir . "/add",
    "admin" => $dir . "/view",
    "open" => "url",
    "edit" => $dir . "/edit",
    "settings" => $Core->url() . "Page/admin/settings",
    "delete" => $Core->url() . "Page/admin/delete"
);
?>

<div class="admin">
    <h2 class="text-center"><?php echo $Plugin->_();?></h2>
    <?php 
        $ListingAPP = new \system\module\Listing\php\ListingAPP(array("row-order" => "ASC", "row-query" => "`tag` = '" . $Object->tag . "'")); 
        $ListingAPP->_("*", $actions, $Object->table, "WHERE `tag` = '" . $Object->tag . "' ORDER by row ASC, id ASC");
    ?>
</div>
<?php
$Object = $Plugin->object();
$dir = \system\Core::this_path(0,-1);

$array = array(
    "name" => array("id" => '$Setting_list = new Setting($list["id"]); echo $Setting_list->_("Title");')
);

$actions = array(
    "add" => $dir . "/add",
    "edit" => "url",
    "setting" => $dir . "/setting",
    "delete" => \system\Core::url() . "Page/admin/delete"
);
?>

<div class="admin">
    <h2 class="text-center"><?php echo $Plugin->_();?></h2>
    <?php 
        require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
        $ListingAPP = new \module\Listing\ListingAPP(array("row-order" => "ASC", "row-query" => "`tag` = '" . $Object->tag . "'")); 
        $ListingAPP->_($array, $actions, $Object->table, "WHERE `tag` = '" . $Object->tag . "' ORDER by `row` ASC, id ASC");
    ?>
</div>
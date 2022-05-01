<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$Object = $Plugin->object("Template");
$dir = \system\Core::this_path(0,-1);
$ListingAPP = new \module\Listing\ListingAPP;

$array = array(
    "bg" => "bg",
);

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit",
    //"delete" => \system\Core::url() . "Page/admin/delete"
);
?>

<div class="admin">
    <h2 class="text-center">Шаблони</h2>
    <?php $ListingAPP->_($array, $actions, $Object->table, "WHERE plugin='Document' AND tag='template' ORDER by bg ASC");?>
</div>
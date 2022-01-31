<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$dir = \system\Core::this_path(0,-1);

$array = [
    "Номер" => ["row" => ' echo "т." . $list["row"];'],
    "Име" => "type",
    "Данъчна основа" => "value",
    "Сума" => ["value" => ' echo number_format($list["value"] * 1.2, 2);']
];

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit",
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \module\Listing\ListingAPP; 
        $ListingAPP->_($array, $actions, $Setting->table, "WHERE fortable='tax' ORDER by row ASC");
    ?>
</div>
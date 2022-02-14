<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP();
$dir = \system\Core::this_path(0, -2);
$actions = array(
    "open" => array('echo \'<a href="' . $dir . '/index?menu=\' . $list["menu"] . \'" class="button block">Open</a>\';')
);

$array = array(
    "name" => "menu"
);
?>


<div class="admin">
<div class="title">Menus</div>
<?php $ListingAPP->_($array, $actions, "module", " WHERE menu != '' GROUP by menu ORDER by id ASC");?>
</div>
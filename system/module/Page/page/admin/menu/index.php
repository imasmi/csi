<?php
$dir = $Core->this_path(0, -2);
$actions = array(
    "open" => array("url" => 'echo "' . $dir . '/index?menu=" . $list["menu"];')
);

$array = array(
    "name" => "menu"
);
?>


<div class="admin">
<div class="title">Menus</div>
<?php 
$ListingAPP = new \system\module\Listing\php\ListingAPP();
$ListingAPP->_($array, $actions, "module", " WHERE menu != '' GROUP by menu ORDER by id ASC");?>
</div>
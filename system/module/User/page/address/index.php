<?php
$dir = \system\Core::this_path(0,-1);

$array = array(
    "id" => "id",
    "default" => array("value" => 'if($list["value"] == "default"){echo "Yes";}'),
    "address" => array("id" => 'foreach($this->PDO->query("SELECT * FROM ' . $Setting->table . ' WHERE link_id=" . $list["id"] . " AND tag != \'additional\'") as $setting){ echo $setting["value"] . "<br/>";}')
);

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>

<div class="admin">
    <div class="title"><?php echo $Text->_("Addresses")?></div>
    <?php $ListingAPP = new \module\Listing\ListingAPP; $ListingAPP->_($array, $actions, $Setting->table, "WHERE `fortable` = '" . $User->table . "' AND page_id='" . $User->_("id") . "' AND link_id='0' AND tag='address'");?>
</div>
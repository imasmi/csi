<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP;

$fields = array(
        "#" => "id",
        "Username" => "username",
        "Group" => "group",
        "Email" => "email",
        "Status" => "status"
);

$actions = $ListingAPP->actions();
$actions["change password"] = \system\Core::this_path(0,-1) . "/change-password";
?>


<div class="admin">
    <?php $ListingAPP->_($fields, $actions, \system\Data::table(), "WHERE deleted is NULL");?>
</div>

<?php

$fields = array(
        "#" => "id", 
        "Username" => "username",
        "Role" => "role",
        "Email" => "email",
        "Status" => "status"
);

$ListingAPP = new \system\module\Listing\php\ListingAPP;
$actions = $ListingAPP->actions();
$actions["change password"] = $Core->this_path(0,-1) . "/change-password";
?>


<div class="admin">
    <?php $ListingAPP->_($fields, $actions, $Query->table(), "WHERE deleted is NULL");?>
</div>
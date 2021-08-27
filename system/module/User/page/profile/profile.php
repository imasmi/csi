 <?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();

#GET USER PROFILE DATA
$profile = $Query->select($User->_("id"));
?>

<div class="admin">
<table class="table">
    <tr>
        <th><?php echo $Text->_("Username");?></th>
        <td><?php echo $profile["username"];?></td>
    </tr>
    
    <tr>
        <td><?php echo $Text->_("Email");?></td>
        <td><?php echo $profile["email"];?></td>
    </tr>
    
    <tr>
        <td><?php echo $Text->_("Created");?></td>
        <td><?php echo date("d.m.Y H:i", strtotime($profile["created"]));?></td>
    </tr>

    <tr><td colspan="2"><button type="button" class="button" onclick="window.open('<?php echo $Core->url() . $Module->_() . '/profile/edit-profile';?>', '_self')"><?php echo $Text->item("Edit profile");?></button></td></tr>
    <tr><td colspan="2"><button type="button" class="button" onclick="window.open('<?php echo $Core->url() . $Module->_() . '/address/index';?>', '_self')"><?php echo $Text->item("Addresses");?></button></td></tr>
    <tr><td colspan="2"><button type="button" class="button" onclick="window.open('<?php echo $Core->url() . $Module->_() . '/profile/change-password';?>', '_self')"><?php echo $Text->item("Change password");?></button></td></tr>
    <tr><td colspan="2"><button type="button" class="button" onclick="window.open('<?php echo $Core->url() . $Module->_() . '/profile/delete';?>', '_self')"><?php echo $Text->item("Delete profile");?></button></td></tr>
</table>
</div>
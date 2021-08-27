<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();

#GET USER PROFILE DATA
$profile = $Query->select($User->_("id"));
?>

<div class="admin">
<div class="error-message" id="error-message"></div>
<form class="form" id="edit-profile" action="<?php echo $Core->query_path();?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path();?>', S.serialize('#edit-profile'), '#error-message')">
    <table class="table">
        <tr>
            <td><?php echo $Text->_("Username");?></td>
            <td><input type="text" name="username" id="username" value="<?php echo $profile["username"];?>" required/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Email");?></td>
            <td><input type="text" name="email" id="email" value="<?php echo $profile["email"];?>" required/></td>
        </tr>
        
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
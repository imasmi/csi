<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();
?>

<div class="admin">
<div class="error-message" id="error-message"></div>
<form class="form" id="change-password" action="<?php echo $Core->query_path();?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path();?>', S.serialize('#change-password'), '#error-message')">
    <table class="table">
        <tr>
            <td><?php echo $Text->_("Password");?></td>
            <td><input type="password" name="password" id="password" required/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("New password");?></td>
            <td><input type="password" name="newpassword" id="newpassword" required/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Retype password");?></td>
            <td><input type="password" name="repassword" id="repassword" required/></td>
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
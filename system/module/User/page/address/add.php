<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();
?>

<div class="admin">
<div class="title"><?php echo $Text->_("Add address");?></div>
<div class="error-message" id="error-message"></div>
<form class="form" id="edit–profile" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#edit–profile'), '#error-message')">
    <table class="table">
        
        <tr>
            <td><?php echo $Text->_("Name");?></td>
            <td><input type="text" name="name" id="name"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Country");?></td>
            <td><input type="text" name="country" id="country"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("City");?></td>
            <td><input type="text" name="city" id="city"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Address");?></td>
            <td><input type="text" name="address" id="address"/></td>
        </tr>
        
        
        <tr>
            <td><?php echo $Text->_("Zip");?></td>
            <td><input type="text" name="zip" id="zip"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Phone");?></td>
            <td><input type="text" name="phone" id="phone"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Additional info");?></td>
            <td><textarea type="text" name="additional" id="additional"></textarea></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Default");?></td>
            <td><input type="checkbox" name="default" id="default"/></td>
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
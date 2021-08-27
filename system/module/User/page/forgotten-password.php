<div class="admin">
<div class="error-message" id="error-message"></div>
<form class="form" id="forgoten-password" action="<?php echo $Core->query_path();?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path();?>', S.serialize('#forgoten-password'), '#error-message'); return false;">
    <table class="table">
        <tr>
            <th><?php echo $Text->_("Email");?></th>
            <td><input type="text" name="email" id="email" required/></td>
        </tr>
        
        <tr>
            <td colspan="2" class="text-center">
                <button type="submit"><?php echo $Text->item("Resend password");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
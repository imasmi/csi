<?php
require_once(\system\Core::doc_root() . "/system/php/Form.php");
$Form = new \system\Form;
?>
<div class="admin">
<div class="error-message" id="error-message"></div>
<form class="form" id="add-user" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#add-user'), '#error-message')">
    <table class="table">
        <tr>
            <td><?php echo $Text->_("Role");?></td>
            <td><?php echo \system\Form::select("role", \system\Data::column_group("role", $User->table), array("select" => "user", "reuqired" => true, "addon" => true));?></td>
        </tr>

        <tr>
            <td><?php echo $Text->_("Username");?></td>
            <td><input type="text" name="username" id="username" required/></td>
        </tr>

        <tr>
            <td><?php echo $Text->_("Email");?></td>
            <td><input type="text" name="email" id="email" required/></td>
        </tr>

        <tr>
            <td><?php echo $Text->_("Password");?></td>
            <td><input type="password" name="password" id="password" required/></td>
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

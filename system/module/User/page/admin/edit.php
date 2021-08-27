<?php
$profile = $Query->select($_GET["id"]);
?>

<div class="admin">
<div class="error-message" id="error-message"></div>
<form class="form" id="edit-user" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', S.serialize('#edit-user'), '#error-message')">
    <table class="table">
        <tr>
            <td><?php echo $Text->_("Role");?></td>
            <td><?php echo $Form->select("role", $Query->column_group("role", $User->table), array("select" => $profile["role"], "reuqired" => true, "addon" => true));?></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Username");?></td>
            <td><input type="text" name="username" id="username" required value="<?php echo $profile["username"];?>"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Email");?></td>
            <td><input type="text" name="email" id="email" required value="<?php echo $profile["email"];?>"/></td>
        </tr>
        
        <tr>
            <td><?php echo $Text->_("Status");?></td>
            <td><input type="text" name="status" id="status" value="<?php echo $profile["status"];?>"/></td>
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
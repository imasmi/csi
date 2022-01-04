<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();

$Setting = new \module\Setting\Setting($User->id, array("fortable" => $User->table));
$address_check = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "' AND page_id='" . $User->id . "' AND link_id='0' AND fortable='" . $User->table . "'");
if($address_check->rowCount() == 1){
    $address = $address_check->fetch();
?>
    <div class="admin">
    <div class="error-message" id="error-message"></div>
    <form class="form" id="edit-profile" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>', S.serialize('#edit-profile'), '#error-message')">
        <table class="table">
            <tr>
                <td><?php echo $Text->_("Country");?></td>
                <td><input type="text" name="country" id="country" value="<?php echo $Setting->_("country", array("link_id" => $_GET["id"]));?>"/></td>
            </tr>
            
            <tr>
                <td><?php echo $Text->_("City");?></td>
                <td><input type="text" name="city" id="city" value="<?php echo $Setting->_("city", array("link_id" => $_GET["id"]));?>"/></td>
            </tr>
            
            <tr>
                <td><?php echo $Text->_("Address");?></td>
                <td><input type="text" name="address" id="address" value="<?php echo $Setting->_("address", array("link_id" => $_GET["id"]));?>"/></td>
            </tr>
            
            
            <tr>
                <td><?php echo $Text->_("Zip");?></td>
                <td><input type="text" name="zip" id="zip" value="<?php echo $Setting->_("zip", array("link_id" => $_GET["id"]));?>"/></td>
            </tr>
            
            <tr>
                <td><?php echo $Text->_("Phone");?></td>
                <td><input type="text" name="phone" id="phone" value="<?php echo $Setting->_("phone", array("link_id" => $_GET["id"]));?>"/></td>
            </tr>
            
            <tr>
                <td><?php echo $Text->_("Additional info");?></td>
                <td><textarea type="text" name="additional" id="additional"><?php echo $Setting->_("additional", array("link_id" => $_GET["id"]));?></textarea></td>
            </tr>
            
            <tr>
                <td><?php echo $Text->_("Default");?></td>
                <td><input type="checkbox" name="default" id="default" <?php echo ($address["value"] == "default") ? "checked" : ""?>/></td>
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
<?php } else { ?>
    <div class="admin">
        <div class="title"><?php echo $Text->_("Error");?></div>
        <div><button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button></div>
    </div>
<?php }?>
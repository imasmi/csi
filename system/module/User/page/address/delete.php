<?php
$address_check = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "' AND page_id='" . $User->id . "' AND link_id='0' AND fortable='" . $User->table . "'");
if($address_check->rowCount() == 1){
    $address = $address_check->fetch();
?>
    <div class="admin">
    <form method="post" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>">
        <table class="table">
            <tr>
                <td colspan="2">Are you sure you want to delete this address? <?php #echo $Text->_("Are you sure you want to delete this user?");?></td>
            </tr>
            
            <tr>
                <td colspan="2" class="title"><?php echo $address["id"];?></td>
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
<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();
?>

<div class="admin">
    <div><?php echo $Text->_("Are you sure you want to delete this user?");?></div>
    <h2><?php echo $Query->select($User->id, "id", $User->table, "username")["username"];?></h2>
    <table class="table">
        <tr>
            <td class="text-center" colspan="2">
                <button type="button" class="button" onclick="window.open('<?php echo $Core->query_path();?>', '_self')"><?php echo $Text->item("Yes");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</div>
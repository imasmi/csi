<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$text = $PDO->query("SELECT * FROM " . $Text->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
?>

<div class="admin">
    <form method="post" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>">
        <table class="table">
                
            <tr>
                <td colspan="2"><?php echo $Text->_("Are you sure you want to delete this text?");?></td>
            </tr>
            
            <tr>
                <td colspan="2"><?php echo $text["tag"];?></td>
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
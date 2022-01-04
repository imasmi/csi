<?php
$select = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
$payment = $PDO->query("SELECT * FROM payment WHERE id='" . $select["page_id"] . "'")->fetch();
?>

<div class="admin">
    <form method="post" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>">
        <table class="table">
            <tr>
                <td colspan="2">Изтриване на плащане?</td>
            </tr>
            
            <tr>
                <td colspan="2" class="title"><?php echo dates::_($payment["date"]);?> за <?php echo $payment["amount"];?> лева</td>
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
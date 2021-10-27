<?php
$select = $Query->select($_GET["id"], "id", $Setting->table);
$payment = $Query->select($select["page_id"], "id", "payment");
?>

<div class="admin">
    <form method="post" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>">
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
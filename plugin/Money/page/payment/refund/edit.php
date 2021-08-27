<?php 
$select = $Query->select($_GET["id"], "id", $Setting->table);
$payment = $Query->select($select["page_id"], "id", "payment");
?>

<div class="admin">
<div class="title">Плащане от <?php echo $date->_($payment["date"]);?> за <?php echo $payment["amount"];?> лева</div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Информация</td>
            <td><input type="text" name="bg" id="bg" value="<?php echo $select["bg"];?>"/></td>
        </tr>
		
		<tr>
            <td>Сума</td>
            <td><input type="number" name="value" id="value" step="0.01" value="<?php echo $select["value"];?>"/></td>
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
<div class="admin">
<h2 class="title text-center">Добавяне на такса</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <input type="hidden" name="caser_id" value="<?php echo $_GET["caser_id"];?>">
    <input type="hidden" name="title_id" value="<?php echo isset($_GET["title_id"]) ? $_GET["title_id"] : 0;?>">
    <input type="hidden" name="debtor_id" value="<?php echo isset($_GET["debtor_id"]) ? $_GET["debtor_id"] : 0;?>">
    <table class="table">
        <tr>
            <td>Точка</td>
            <td>
                <select name="setting_id" id="setting_id" requried onchange="S('#count').value = 1; S('#sum').value = this.options[this.selectedIndex].getAttribute('data-sum');"  class="tax-chooser">
                    <option value="">ИЗБОР НА ТАКСА</option>
                    <?php foreach ($PDO->query("SELECT id, `row`, `type`, value FROM " . $Setting->table . " WHERE `fortable`='tax'") as $tax) { ?>
                        <option value="<?php echo $tax["id"];?>" data-sum="<?php echo number_format($tax["value"] * 1.2, 2);?>">т. <?php echo $tax["row"];?> - <?php echo $tax["type"];?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Брой</td>
            <td><input type="number" step="1" name="count" id="count" onkeyup="let setting_id = S('#setting_id'); S('#sum').value = (Number(setting_id.options[setting_id.selectedIndex].getAttribute('data-sum')) * Number(this.value)).toFixed(2);" required/></td>
        </tr>
        
        <tr>
            <td>Сума</td>   
            <td><input type="number" step="0.01" name="sum" id="sum" required/></td>
        </tr>

        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" required/></td>
        </tr>

        <tr>
            <td>Бележка</td>
            <td><textarea name="note" id="" cols="30" rows="5"></textarea></td>
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
<?php 
$select = $PDO->query("SELECT * FROM debt WHERE id='" . $_GET["id"] . "'")->fetch();
?>

<div class="admin">
<h2 class="title text-center">Редакция на дълг</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Вид вземане</td>
            <td>
                <select name="setting_id" id="setting_id" requried onchange="S('#debt-date').style.display = this.value ==  110 ? 'table-row' : 'none'; S.post('<?php echo \system\Core::query_path(0, -1);?>/sub-select', {id: this.value}, '#sub-debt')"  class="tax-chooser">
                    <option value="">Избери</option>
                    <?php foreach ($PDO->query("SELECT id, `type` FROM " . $Setting->table . " WHERE `fortable`='debt' AND link_id=0") as $debt) { ?>
                        <option value="<?php echo $debt["id"];?>" <?php if ($select["setting_id"] == $debt["id"]) { echo 'selected';}?>><?php echo $debt["type"];?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Описание</td>
            <td id="sub-debt">
            <select name="subsetting_id" id="subsetting_id"  class="tax-chooser">
                <option value="">Избери </option>
                <?php 
                foreach ($PDO->query("SELECT id, `type` FROM " . $Setting->table . " WHERE `fortable`='debt' AND link_id='" . $select["setting_id"] . "'") as $debt) { ?>
                    <option value="<?php echo $debt["id"];?>" <?php if ($debt["id"] == $select["subsetting_id"]) { echo 'selected';}?>><?php echo $debt["type"];?></option>
                <?php } ?>
            </select>
            </td>
        </tr>

        <tr>
            <td>Сума</td>   
            <td><input type="number" step="0.01" name="sum" id="sum" value="<?php echo $select["sum"];?>" required/></td>
        </tr>

        <tr id="debt-date" class="<?php if ($select["setting_id"] != 110) {echo 'hide';}?>">
            <td>Дата за лихва</td>   
            <td><input type="date" name="start" id="start" value="<?php echo $select["start"];?>"/></td>
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
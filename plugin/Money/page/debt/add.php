<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($_GET["caser_id"]);
?>
<div class="admin">
<h2 class="title text-center">Добавяне на дълг</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <input type="hidden" name="caser_id" value="<?php echo $_GET["caser_id"];?>">
    <input type="hidden" name="title_id" value="<?php echo isset($_GET["title_id"]) ? $_GET["title_id"] : 0;?>">
    <table class="table">
        <tr>
            <td>Вид вземане</td>
            <td>
                <select name="setting_id" id="setting_id" requried onchange="S('#debt-date').style.display = this.value ==  110 ? 'table-row' : 'none'; S.post('<?php echo \system\Core::query_path(0, -1);?>/sub-select', {id: this.value}, '#sub-debt')"  class="tax-chooser">
                    <option value="">Избери </option>
                    <?php foreach ($PDO->query("SELECT id, `type` FROM " . $Setting->table . " WHERE `fortable`='debt' AND link_id=0") as $debt) { ?>
                        <option value="<?php echo $debt["id"];?>"><?php echo $debt["type"];?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Описание</td>
            <td id="sub-debt"></td>
        </tr>

        <tr>
            <td>Сума</td>   
            <td><input type="number" step="0.01" name="sum" id="sum" required/></td>
        </tr>

        <tr id="debt-date" class="hide">
            <td>Дата за лихва</td>   
            <td><input type="date" name="start" id="start" value="0000-00-00"/></td>
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
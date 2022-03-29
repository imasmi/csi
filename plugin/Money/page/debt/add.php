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
    <table class="table center">
        <tr>
            <td>Титул</td>
            <td>
                <select name="title_id" required onchange="S.post('<?php echo \system\Core::url();?>Money/query/tax/title-debtors-select', {id: this.value, caser_id : '<?php echo $_GET["caser_id"];?>'}, '#debtors-select')">
                    <option value="">ИЗБЕРИ</option>
                    <?php 
                        $titles = [];
                        foreach($Caser->title as $title){
                        ?>
                            <option value="<?php echo $title["id"];?>" <?php if (isset($_GET["title_id"]) && $_GET["title_id"] == $title["id"]) { echo 'selected';}?>><?php echo $title["number"];?></option>
                        <?php
                        }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Длъжници</td>
            <td id="debtors-select">
                <?php 
                $debotrs = [];
                $debtor_items = [];
                foreach ($Caser->debtor($_GET["title_id"]) as $debtor) {
                    $debotrs[$debtor] = $PDO->query("SELECT name FROM person WHERE id='" . $debtor . "'")->fetch()["name"];
                    if (isset($_GET["debtor_id"])) {
                        if ($_GET["debtor_id"] == $debtor) {$debtor_items[] = $debtor;}
                    } else {
                        $debtor_items[] = $debtor;
                    }
                }
                \system\Form::multiselect("debtor_id", ["data" => $debotrs, "items" => $debtor_items]);
                ?>
            </td>
        </tr>
    </table>

    <h3 class="text-center">Суми</h3>

    <div class="flex flex-between">
        <div></div>
        <div>Вид вземане</div>
        <div>Описание</div>
        <div>Дата за лихва</div>
        <div>Сума</div>
    </div>
    
    <div id="multiselect-items-row">

    </div>

    <div>
        <button type="button" class="button" onclick="
            let newRow = document.createElement('div');
            let cnt = Number(S('#multiselect-counter-row').value);
            newRow.innerHTML = S('#multiselect-template-row').innerHTML.replace(/-cnt/g, `-${cnt}`);
            console.log(newRow);
            let newId = `multiselect-row-${cnt}`;
            newRow.setAttribute('id', newId);
            newRow.setAttribute('class', 'flex flex-between');
            newRow.querySelector('.remove-button-row').setAttribute('onclick', `S.remove('#${newId}');`);
            newRow.querySelector('#multiselect-' + cnt).innerHTML = cnt;
            S('#multiselect-items-row').appendChild(newRow);
            S('#multiselect-counter-row').value = cnt + 1;
            ">+</button>
            <input type="hidden" id="multiselect-counter-row" name="multiselect-counter-row" value="1"/>
    </div>
    
    <div class="text-center margin-top-30">
        <button class="button"><?php echo $Text->item("Save");?></button>
        <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
    </div>


</form>
</div>

<div id="multiselect-template-row" class="hide">
    <div id="multiselect-cnt"></div>
    <div>
        <select name="setting_id-cnt" id="setting_id" requried onchange="S.post('<?php echo \system\Core::query_path(0, -1);?>/sub-select', {id: this.value, name_cnt: '-cnt'}, '#sub-debt-cnt')"  class="tax-chooser">
            <option value="">Избери </option>
            <?php foreach ($PDO->query("SELECT id, `type` FROM " . $Setting->table . " WHERE `fortable`='debt' AND link_id=0") as $debt) { ?>
                <option value="<?php echo $debt["id"];?>"><?php echo $debt["type"];?></option>
            <?php } ?>
        </select>
    </div>
    <div id="sub-debt-cnt"></div>
    <div id="debt-date-cnt"><input type="date" name="start-cnt" id="start-cnt" value="<?php echo date("Y-m-d");?>"/></div>
    <div><input type="number" step="0.01" name="sum-cnt" id="sum-cnt" required/></div>
    <div><button type="button" class="button remove-button-row">-</button></div>
</div>
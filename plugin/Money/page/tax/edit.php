<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$select = $select = $PDO->query("SELECT * FROM tax WHERE id='" . $_GET["id"] . "'")->fetch();
$Caser = new \plugin\Caser\Caser($select["caser_id"]);
?>

<div class="admin">
<h2 class="title text-center">Редакция на такса т.<?php echo $select["point_number"];?></h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Точка</td>
            <td>
                <select name="setting_id" id="setting_id" requried onchange="S('#count').value = 1; S('#sum').value = this.options[this.selectedIndex].getAttribute('data-sum');"  class="tax-chooser">
                    <option value="">ИЗБОР НА ТАКСА</option>
                    <?php foreach ($PDO->query("SELECT id, `row`, `type`, value FROM " . $Setting->table . " WHERE `fortable`='tax'") as $tax) { ?>
                        <option value="<?php echo $tax["id"];?>" data-sum="<?php echo number_format($tax["value"] * 1.2, 2);?>" <?php if($select["setting_id"] == $tax["id"]) { echo 'selected';}?>>т. <?php echo $tax["row"];?> - <?php echo $tax["type"];?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Брой</td>
            <td><input type="number" step="1" name="count" id="count" value="<?php echo $select['count'];?>" onkeyup="let setting_id = S('#setting_id'); S('#sum').value = (Number(setting_id.options[setting_id.selectedIndex].getAttribute('data-sum')) * Number(this.value)).toFixed(2);" required/></td>
        </tr>

        <tr>
            <td>Сума</td>   
            <td><input type="number" step="0.01" name="sum" id="sum" value="<?php echo $select['sum'];?>" required/></td>
        </tr>

        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" value="<?php echo $select['date'];?>" required/></td>
        </tr>

        <tr>
            <td>Бележка</td>
            <td><textarea name="note" id="" cols="30" rows="5"><?php echo $select['note'];?></textarea></td>
        </tr>

        <tr>
            <td>Титул</td>
            <td>
                <select name="title_id" onchange="S.post('<?php echo \system\Core::url();?>Money/query/tax/title-debtors-select', {id: this.value, caser_id : '<?php echo $select["caser_id"];?>'}, '#debtors-select')">
                    <option value="0">ИЗБЕРИ</option>
                    <?php 
                        $titles = [];
                        foreach($Caser->title as $title){
                        ?>
                            <option value="<?php echo $title["id"];?>" <?php if ($select["title_id"] == $title["id"]) { echo 'selected';}?>><?php echo $title["number"];?></option>
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
                $debtor_items = $select["debtors"] !== null ? json_decode($select["debtors"], true) : [];
                foreach ($Caser->debtor($select["title_id"]) as $debtor) {
                    $debotrs[$debtor] = $PDO->query("SELECT name FROM person WHERE id='" . $debtor . "'")->fetch()["name"];
                }
                \system\Form::multiselect("debtor_id", ["data" => $debotrs, "items" => $debtor_items]);
                ?>
            </td>
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
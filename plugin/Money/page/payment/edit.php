<?Php 
$select = $PDO->query("SELECT * FROM payment WHERE id='" . $_GET["id"] . "'")->fetch();
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($select["case_id"]);
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
$Person = new \plugin\Person\Person($select["person"]);
?>
<div class="admin">
<h2 class="title">Add payment</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Дело</td>
            <td><?php $Caser->select("case_id");?></td>
        </tr>

        <tr>
            <td>Вносител</td>
            <td><?php $Person->select("person");?></td>
        </tr>

        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" value="<?php echo $select["date"];?>"/></td>
        </tr>

        <tr>
            <td>Сума</td>
            <td><input type="number" name="amount" id="amount" onblur="S('#allocate').value = this.value;" value="<?php echo $select["amount"];?>"/></td>
        </tr>

        <tr>
            <td>За разпределяне</td>
            <td><input type="number" name="allocate" id="allocate" value="<?php echo $select["allocate"];?>"/></td>
        </tr>

        <tr>
            <td>Бордеро</td>
            <td><input type="number" name="bordero" value="<?php echo $select["bordero"];?>"/></td>
        </tr>

        <tr>
            <td>Описание</td>
            <td><textarea name="description" id="description"><?php echo $select["description"];?></textarea></td>
        </tr>

        <tr>
            <td>Вносител</td>
            <td><textarea name="debtor" id="debtor"><?php echo $select["debtor"];?></textarea></td>
        </tr>

        <tr>
            <td>Получател</td>
            <td><textarea name="creditor" id="creditor"><?php echo $select["creditor"];?></textarea></td>
        </tr>

        <tr>
            <?php 
            $banks = [];
            foreach ($PDO->query ("SELECT id, IBAN, `description` FROM bank WHERE person_id='1'") as $bank) {
                $banks[$bank["id"]] = $bank["IBAN"] . ' - ' . $bank["description"];
            }
            ?>
            <td>Банка</td>
            <td><?php \system\Form::select("bank", $banks, ["select" => $select["bank"]]);?></td>
        </tr>

        <tr>
            <td>Основание</td>
            <td><?php \system\Form::select("reason", system\Database::column_group("reason", "payment"), ["select" => $select["reason"]]);?></td>
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
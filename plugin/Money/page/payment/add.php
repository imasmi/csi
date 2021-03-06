<?Php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($_GET["case_id"]);
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
$Person = new \plugin\Person\Person;
?>
<div class="admin">
<h3 class="text-center">Добавяне на плащане</h3>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Дело</td>
            <?php $case_array = isset($_GET["case_id"]) ? ["id" => $_GET["case_id"]] : [];?>
            <td><?php $Caser->select("case_id", $case_array);?></td>
        </tr>

        <tr>
            <td>Длъжници</td>
            <td>
                <?php 
                    $debtors = [];
                    foreach ($Caser->debtor as $debtor) {
                        $debtors[$debtor] = $PDO->query("SELECT name FROM person WHERE id='" . $debtor . "'")->fetch()["name"];
                    }
                    \system\Form::multiselect("debtor_id", ["data" => $debtors]);
                ?>
            </td>
        </tr>

        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" value="<?php echo date("Y-m-d H:i:s");?>" required/></td>
        </tr>

        <tr>
            <td>Сума</td>
            <td><input type="number" name="amount" id="amount" onblur="S('#allocate').value = this.value;"/></td>
        </tr>

        <tr>
            <td>За разпределяне</td>
            <td><input type="number" name="allocate" id="allocate"/></td>
        </tr>

        <tr>
            <td>Бордеро</td>
            <td><input type="number" name="number"/></td>
        </tr>

        <tr>
            <td>Описание</td>
            <td><textarea name="description" id="description"></textarea></td>
        </tr>

        <tr>
            <td>Вносител</td>
            <td><?php echo $Person->select("sender");?></td>
        </tr>

        <tr>
            <td>Получател</td>
            <td><?php echo $Person->select("receiver", ["id" => 1]);?></td>
        </tr>

        <tr>
            <?php 
            $banks = [];
            foreach ($PDO->query ("SELECT id, IBAN, `description` FROM bank WHERE person_id='1'") as $bank) {
                $banks[$bank["id"]] = $bank["IBAN"] . ' - ' . $bank["description"];
            }
            ?>
            <td>Банка</td>
            <td><?php \system\Form::select("bank", $banks, ["required" => true]);?></td>
        </tr>

        <tr>
            <td>Основание</td>
            <td><?php \system\Form::select("reason", system\Data::column_group("reason", "payment"));?></td>
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
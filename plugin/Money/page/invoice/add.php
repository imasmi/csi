<?php 
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
$Person = new \plugin\Person\Person;
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($_GET["case_id"]);

$invoice_taxes = [];
$bill_taxes = [];
foreach($_POST as $tax_post => $value){
    $tax = $PDO->query("SELECT * FROM tax WHERE id='" . str_replace("tax_", "", $tax_post) . "'")->fetch();
    if ($tax["point_number"] == 31) {
        $bill_taxes[$tax["id"]] = $tax;
    } else {
        $invoice_taxes[$tax["id"]] = $tax;
    }
}
?>
<div class="admin">
<h2 class="text-center title">Счетоводни документи</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="case_id" value="<?php echo $_GET["case_id"];?>">
    <table class="table center">
        <tr>
            <td>Задължено лице</td>
            <td><?php echo $Person->select("payer", ["id" => $Caser->creditor[0]]);?></td>
        </tr>
        
        <tr>
            <td>Дата</td>
            <td><input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" required/></td>
        </tr>

        <tr>
            <td>Плащане</td>
            <td></td>
        </tr>

        <tr>
            <td>Банка</td>
            <td></td>
        </tr>
    </table>

    <div class="flex flex-evenly">
        <?php if (!empty($invoice_taxes)) { ?>
            <fieldset>
                <legend>Такси</legend>
                <table>
                    <?php foreach ($invoice_taxes as $tax) { 
                        ?>
                        <tr>
                            <td><?php echo 'т. ' . $tax["point_number"];?></td>
                            <td><input type="number" name="tax_<?php echo $tax["id"];?>" value="<?php echo $tax["sum"];?>"></td>
                        </tr>
                        <?php
                    }?>
                </table>
            </fieldset>
        <?php } ?>

        <?php if (!empty($bill_taxes)) { ?>
            <fieldset>
                <legend>Разноски</legend>
                <table>
                    <?php foreach ($bill_taxes as $bill) { 
                        ?>
                        <tr>
                            <td><?php echo 'т. ' . $bill["point_number"];?></td>
                            <td><input type="number" name="bill_<?php echo $bill["id"];?>" value="<?php echo $bill["sum"];?>"></td>
                        </tr>
                        <?php
                    }?>
                </table>
            </fieldset>
        <?php } ?>
    </div>

    <div class="text-center margin-top-20">
        <button class="button"><?php echo $Text->item("Next");?></button>
        <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
    </div>
</form>
</div>
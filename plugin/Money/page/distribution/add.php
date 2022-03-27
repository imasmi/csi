<?php 
require_once(\system\Core::doc_root() . "/plugin/Person/php/Person.php");
require_once(\system\Core::doc_root() . "/plugin/Money/php/Money.php");
$Caser = new \plugin\Caser\Caser($_POST["case_id"]);
?>

<div class="admin">
<h3 class="text-center">Разпределяне на плащания по дело <?php echo $Caser->number;?></h3>
<div class="error-message" id="error-message"></div>
    <form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
        <h3>Плащания</h3>
        <table class="table">
            <tr>
                <th>Дата</th>
                <th>Длъжник</th>
                <th>Сума</th>
            </tr>
    <?php 
        $payments = [];
        $total = 0;
        foreach ($_POST as $key => $value) {
            if (strpos($key, "payment_") !== false) {
                $payment = $PDO->query("SELECT id, `date`, debtors, unpartitioned FROM payment WHERE id='" . explode("payment_", $key)[1] . "'")->fetch();
                $total += $payment["unpartitioned"];
                ?>
                <tr>
                    <td><?php echo $payment["date"];?></td>
                    <td><?php \plugin\Person\Person::list(json_decode($payment["debtors"], true));?></td>
                    <td><input type="number" id="payment-<?php echo $payment["id"];?>" class="distribute-sum" value="<?php echo $payment["unpartitioned"];?>" onchange="if (Number(this.value) < 0 || Number(this.value) > '<?php echo $payment["unpartitioned"];?>') { S.info('Изберете сума между 0 и <?php echo $payment["unpartitioned"];?> лева'); this.value='<?php echo $payment["unpartitioned"];?>';} else {let total = 0; S.all('.distribute-sum', el => total += Number(el.value)); S('#distribute').innerHTML = total.toFixed(2);}"></td>
                </tr>
                <?php
            }
        }
    ?>
        <tr>
            <th colspan="2">За погасяване</th>
            <th id="distribute"><?php echo \plugin\Money\Money::sum($total);?></th>
        </tr>
        </table>
    </form>
</div>
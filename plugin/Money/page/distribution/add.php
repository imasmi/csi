<?php 
require_once(\system\Core::doc_root() . "/plugin/Person/php/Person.php");
require_once(\system\Core::doc_root() . "/plugin/Money/php/Money.php");
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/web/php/dates.php');
use \plugin\Person\Person;
use \plugin\Money\Money;
$Caser = new \plugin\Caser\Caser($_POST["case_id"]);
$Money = new Money($_POST["case_id"]);
?>

<div class="admin">
<h3 class="text-center">Разпределяне на плащания по дело <?php echo $Caser->number;?></h3>
<div class="error-message" id="error-message"></div>
    <form class="form text-center" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
        <input type="hidden" name="case_id" value="<?php echo $_POST["case_id"];?>" />
        <input type="date" name="date" value="<?php echo date("Y-m-d");?>" />
        <h3 class="inline-block marginY-0">Плащания</h3>
        <table class="table center">
            <tr>
                <th>Дата</th>
                <th>Длъжник</th>
                <th>Налични</th>
                <th>Използвай</th>
                <th>Остатък за погасяване</th>
            </tr>
    <?php 
        $payments = [];
        $total = 0;
        foreach ($_POST as $key => $value) {
            if (strpos($key, "payment_") !== false) {
                $payment = $PDO->query("SELECT id, `date`, debtor, unpartitioned FROM payment WHERE id='" . explode("payment_", $key)[1] . "'")->fetch();
                $total += $payment["unpartitioned"];
                ?>
                <tr>
                    <td><?php echo $payment["date"];?></td>
                    <td><?php Person::list(json_decode($payment["debtor"], true));?></td>
                    <td><?php echo $payment["unpartitioned"];?></td>
                    <td><input type="number" id="payment-<?php echo $payment["id"];?>" name="payment-<?php echo $payment["id"];?>" class="distribute-sum" value="<?php echo $payment["unpartitioned"];?>" onchange="if (Number(this.value) < 0 || Number(this.value) > '<?php echo $payment["unpartitioned"];?>') { S.info('Изберете сума между 0 и <?php echo $payment["unpartitioned"];?> лева'); this.value='<?php echo $payment["unpartitioned"];?>';} else {let total = 0; S.all('.distribute-sum', el => total += Number(el.value)); S('#distribute-amount').innerHTML = total.toFixed(2); S('#distribute-sum').innerHTML = total.toFixed(2);}"></td>
                    <td></td>
                </tr>
                <?php
            }
        }
    ?>
        <tr>
            <th colspan="3">За погасяване</th>
            <th id="distribute-amount"><?php echo Money::sum($total);?></th>
            <td id="distribute-sum"><?php echo Money::sum($total);?></td>
        </tr>
        </table>

        
        <div class="marginY-20"><button class="button color-1-bg" type="button" onclick="csi.distributeAuto()">Разпредели автоматично</button></div>
        <div id="distribute-data">
            <?php 
            
            $debt_types = Money::debt_types();
            foreach ($Money->debts() as $debt) {
                $title = $PDO->query("SELECT * FROM caser_title WHERE id='" . $debt["title_id"] . "'")->fetch();
            ?>  
                <div class="margin-top-20">
                    <table class="center">
                        <tr>
                            <td>Взискатели</td>
                            <th><?php Person::list(json_decode($title["creditor"]));?></th>
                            <td>Длъжници</td>
                            <th><?php Person::list(json_decode($title["debtor"]));?></th>
                        </tr>
                        <tr>
                            <th colspan="5">Дълг към титул <?php echo $title["number"];?></th>
                            <td colspan="3" class="color-1-bg">Погаси</td>
                        </tr>

                        <tr>
                            <th></th>
                            <th>Вид вземане</th>
                            <th>Тип</th>
                            <th>Сума</th>
                            <th>т.26</th>
                            <td>т.26</td>
                            <td>Сума</td>
                            <td>Общо</td>
                        </tr>

                        <?php 
                        $cnt = 0;
                        foreach ($debt["items"] as $item) {
                            $order = $debt_types[$item["setting_id"]]["row"];
                        ?>
                            <tr>
                                <td><?php echo ++$cnt;?></td>
                                <td><?php echo $debt_types[$item["setting_id"]]["type"];?></td>
                                <td><?php echo $debt_types[$item["subsetting_id"]]["type"];?></td>
                                <td><?php echo $item["unpaid"];?></td>
                                <td><?php echo $item["tax-unpaid"];?></td>
                                <td><input type="number" name="prop-<?php echo $item["id"];?>" id="prop-<?php echo $item["id"];?>" debt-id="<?php echo $debt["id"];?>" max="<?php echo $item["tax-unpaid"];?>" data-current="0" value="0" step="0.01" onchange="csi.distribute(this)"></td>
                                <td><input type="number" name="sum-<?php echo $item["id"];?>" id="sum-<?php echo $item["id"];?>" debt-id="<?php echo $debt["id"];?>" max="<?php echo $item["unpaid"];?>" data-current="0" value="0" step="0.01" onchange="csi.distribute(this)"></td>
                                <td><input type="number" id="total-<?php echo $item["id"];?>" data-order="<?php echo $item["type"] == "interest" ? $order + 1 : $order;?>" debt-id="<?php echo $debt["id"];?>" max="<?php echo $item["unpaid"] + $item["tax-unpaid"];?>" data-current="0" value="0" step="0.01" onchange="csi.distribute(this)"></td>
                            </tr>
                        <?php
                            if ($item["type"] == "interest") {
                                $sub_cnt = 0;
                                foreach ($item["interest"] as $interest) {
                                ?>
                                    <tr>
                                        <td><?php echo $cnt . '.' . ++$sub_cnt;?>)</td>
                                        <td colspan="2">Законна лихва върху <?php echo $interest["sum"];?> лева от <?php echo \web\dates::_($interest["date"]);?></td>
                                        <td><?php echo $interest["unpaid"];?></td>
                                        <td><?php echo $interest["tax-unpaid"];?></td>
                                        <td><input type="number" name="prop-<?php echo $interest["id"];?>" id="prop-<?php echo $interest["id"];?>" debt-id="<?php echo $debt["id"];?>" max="<?php echo $interest["tax-unpaid"];?>" data-current="0" value="0" step="0.01" onchange="csi.distribute(this)"></td>
                                        <td><input type="number" name="sum-<?php echo $interest["id"];?>" id="sum-<?php echo $interest["id"];?>" debt-id="<?php echo $debt["id"];?>" max="<?php echo $interest["unpaid"];?>" data-current="0" value="0" step="0.01" onchange="csi.distribute(this)"></td>
                                        <td><input type="number" id="total-<?php echo $interest["id"];?>" data-order="<?php echo $order;?>" debt-id="<?php echo $debt["id"];?>" max="<?php echo $interest["unpaid"] + $interest["tax-unpaid"];?>" data-current="0" value="0" step="0.01" onchange="csi.distribute(this)"></td>
                                    </tr>
                                <?php    
                                }
                            }
                        }
                        ?>

                        <tr>
                            <th>Общо</th>
                            <th></th>
                            <th></th>
                            <th><?php echo $debt["unpaid"]?></th>
                            <th><?php echo $debt["tax-unpaid"]?></th>
                            <th id="prop-<?php echo $debt["id"];?>" class="total">0</th>
                            <th id="sum-<?php echo $debt["id"];?>" class="total">0</th>
                            <th id="total-<?php echo $debt["id"];?>" class="total">0</th>
                        </tr>

                    </table>
                </div>
            <?php } ?>
            
            <h3>Такси</h3>
            <table cellpadding="5" cellspacing="0" class="border-bottom-row center">
                <tr>
                    <th>Точка</th>
                    <th>Брой</th>
                    <th>Дата</th>
                    <th>Длъжници</th>
                    <th>Сума</th>
                    <td class="color-1-bg">Погаси</td>
                </tr>
                <?php 
                
                $total_count = 0;
                
                foreach ($Money->taxes as $tax) { 
                    if ($tax["unpaid"] > 0) { 
                    ?>
                    <tr>
                        <td>т.<?php echo $tax["point_number"];?></td>
                        <td><?php echo $tax["count"]; $total_count += $tax["count"];?></td>
                        <td><?php echo web\dates::_($tax["date"]);?></td>
                        <td>
                            <?php 
                                if ($tax["debtor"] != null) {
                                    foreach(json_decode($tax["debtor"], true) as $debtor_id){
                                        ?>
                                        <div><?php echo $PDO->query("SELECT name FROM person WHERE id='" . $debtor_id . "'")->fetch()["name"];?></div>
                                        <?php
                                    }
                                }
                            ?>
                        </td>
                        <td><?php echo $tax["unpaid"];?></td>
                        <td><input type="number" name="tax-<?php echo $tax["id"];?>" data-order="0" id="tax-<?php echo $tax["id"];?>" max="<?php echo $tax["unpaid"];?>" data-current="0" onchange="csi.distribute(this)" value="0" step="0.01"></td>
                    </tr>
                <?php }} ?>
                <tr>
                    <th>Общо</th>
                    <th><?php echo $total_count;?></th>
                    <th colspan="2"></th>
                    <th><?php echo Money::sum($Money->total["tax"]["sum"]);?></th>
                    <th id="tax-total" class="total">0</th>
                </tr>
            </table>
        </div>

        <div class="margin-top-20">
            <div class="marginY-10"><input type="checkbox" name="add_invoice" checked>Издай счетоводни документи</div>
            <button type="button" class="button" onclick="history.back()">Назад</button>
            <button type="submit" class="button">Запази</button>
        </div>
    </form>
</div>
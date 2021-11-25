<?php 
$fast_match = json_decode($_POST["fast_match"], true);
?>

<form method="post" action="<?php echo $Core->query_path();?>">
    <table class="admin">
        <tr>
            <th></th>
            <th></th>
            <th>Сума</th>
            <th>Дата</th>
            <th>Описание</th>
            <th>Дело</th>
            <th>Фактури</th>
        </tr>

        <?php foreach($fast_match as $cnt => $payment) {
            $case_number = $Query->select($payment["case_id"], "id", "caser", "number")["number"];
            ?>
            <input type="hidden" name="<?php echo $cnt;?>_payment" value="<?php echo $payment["id"];?>"/>
            <tr id="row-<?php echo $cnt;?>">
                <td><button class="button" onclick="S.remove('#row-<?php echo $cnt;?>')">-</button></td>
                <td><?php echo $cnt + 1;?></td>
                <td><?php echo $payment["amount"];?></td>
                <td><?php echo $payment["description"];?></td>
                <td><?php echo $case_number;?></td>
                <td>
                    <?php 
                        $left_money = $payment["amount"];
                        foreach($PDO->query("SELECT id, `sum`, invoice, bill, `type`, `date`  FROM invoice WHERE case_id='" . $payment["case_id"] . "' AND `date`>='" . $payment["date"]. "' AND payment is NULL ORDER by sum DESC") as $invoice){
                            if($invoice["sum"] <= $left_money){
                            ?>
                            <div>
                                <input type="checkbox" name="<?php echo $cnt;?>_<?php echo $invoice["id"];?>" checked/>
                                <?php echo $invoice["sum"];?>
                                - <?php echo $invoice["type"] == "invoice" ? "фактура " . $invoice["invoice"] : "Сметка " . $invoice["bill"]; echo '/' . date("d.m.Y", strtotime($invoice["date"]));?>
                            </div>
                            <?php
                            $left_money -= $invoice["sum"];
                            if($left_money == 0){break;}
                            }
                        }
                    
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="text-center"><button class="button">Save</button></div>
</form>
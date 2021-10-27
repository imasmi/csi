<?php
$Money = new plugin\Money\php\Money;
if(!isset($_GET["start"])){
    ?>
    <h2 class="text-center marginY-50">Изберете дати</h2>
    <?php
    exit;
}

$months = ceil((strtotime($_GET["end"]) - strtotime($_GET["start"])) / (3600 * 24 * 30));
$creditors = [];
foreach($PDO->query("SELECT creditor, case_id FROM caser_title") as $caser_title){
    $creditor = json_decode($caser_title["creditor"], true);
    $status = $Query->select($caser_title["case_id"], "id", "caser", "status")["status"];
    if(($status === "ВИСЯЩО" || $status === "ВЪЗОБНОВЕНО") && isset($creditor[0])){
        $creditors[$creditor[0]] = isset($creditors[$creditor[0]]) ? $creditors[$creditor[0]] + 1 : 1;
    }
}
arsort($creditors);

$money = [];
foreach($creditors as $creditor => $cases_count){
    foreach($PDO->query("SELECT creditors, `date`, csiTotal FROM distribution WHERE date > '" . $_GET["start"] . " 00:00:00' AND  creditors LIKE '%\"" . $creditor . "\"%' ORDER by `date` ASC") as $distribution){
        $payed = json_decode($distribution["creditors"], true);
        foreach($payed as $data){
            if(key($data) == $creditor){
                $money[$creditor][$distribution["date"]] = ["creditor" => $data[$creditor], "tax" => $distribution["csiTotal"]];
            }
        }
    }
}
?>
<div class="admin">
    <table>
        <tr>
            <th>#</th>
            <th>Взискател</th>
            <th>Активни дела</th>
            <th></th>
            <?php for ($a = $months; $a > 0; $a--) {?>
                <th>
                    <div><?php echo date("Y", strtotime("-" . $a . " months"));?></div>
                    <?php echo \web\php\dates::$months[date("n", strtotime("-" . $a . " months"))];?>
                </th>
            <?php } ?>
            <th>Общо</th>
        </tr>
        
        <?php 
        $cnt = 1;
        $total_sum = 0;
        $total_tax = 0;
        $total_cases = 0;
        $month_sums = [];
        $month_taxes = [];
        foreach($creditors as $creditor => $cases_count){
            $creditor_sum = 0;
            $creditor_tax = 0;
            $name = $Query->select($creditor, "id", "person", "name")["name"];
        ?>
            <tr>
                <td rowspan="2"><?php echo $cnt++;?></td>
                <td rowspan="2" style="max-width: 200px; font-size: 15px;"><?php echo $name;?></td>
                <td rowspan="2"><?php echo $cases_count;?></td>
                <td class="color-1-bg">За взискател</td>
                <?php for ($a = $months; $a >= 1; $a--) {
                    $start = date("Y-m-01 00:00:00", strtotime("-" . ($a - 1) . " months"));
                    $end = date("Y-m-31 23:59:59", strtotime("-" . ($a - 1) . " months"));
                    $month_sum = 0;
                    ?>
                    <td class="color-1-bg">
                        <?php 
                        if(isset($money[$creditor])){
                            foreach($money[$creditor] as $date => $sum){
                                if($date >= $start && $date < $end){
                                    $month_sum += $sum["creditor"];
                                }
                            }
                        }
                        echo $Money->sum($month_sum);
                        ?>
                    </td>
                <?php 
                $creditor_sum += $month_sum;
                $month_sums[$a] += $month_sum;
                }
                ?>
                <th><?php echo $Money->sum($creditor_sum);?></th>
            </tr>

            <tr>
                <td>За ЧСИ</td>
                <?php for ($a = $months; $a >= 1; $a--) {
                    $start = date("Y-m-01 00:00:00", strtotime("-" . ($a - 1) . " months"));
                    $end = date("Y-m-31 23:59:59", strtotime("-" . ($a - 1) . " months"));
                    $month_tax = 0;
                    ?>
                    <td>
                        <?php 
                        if(isset($money[$creditor])){
                            foreach($money[$creditor] as $date => $sum){
                                if($date >= $start && $date < $end){
                                    $month_tax += $sum["tax"];
                                }
                            }
                        }
                        echo $Money->sum($month_tax);
                        ?>
                    </td>
                <?php 
                $creditor_tax += $month_tax;
                $month_taxes[$a] += $month_tax;
                } 
                ?>
                <td><?php echo $Money->sum($creditor_tax);?></td>
            </tr>
        <?php
            $total_sum += $creditor_sum;
            $total_tax += $creditor_tax;
            $total_cases += $cases_count;
        }
        ?>

        <tr>
            <th rowspan="2"></th>
            <th rowspan="2">ОБЩО</th>
            <th rowspan="2"><?php echo $total_cases;?></th>
            <td class="color-1-bg">За взискател</td>
            <?php for ($a = $months; $a > 0; $a--) {?>
                <td class="color-1-bg"><?php echo $Money->sum($month_sums[$a]);?></td>
            <?php } ?>
            <th><?php echo $Money->sum($total_sum);?></th>
        </tr>

        <tr>
            <td>За ЧСИ</td>
            <?php for ($a = $months; $a > 0; $a--) {?>
                <td><?php echo $Money->sum($month_taxes[$a]);?></td>
            <?php } ?>
            <td><?php echo $Money->sum($total_tax);?></td>
        </tr>
    </table>
</div>
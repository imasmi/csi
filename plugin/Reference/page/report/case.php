<?php
/* Transform old serialized values to JSON
foreach ($PDO->query("SELECT * FROM report WHERE year='2021' AND period='1' AND `type`='case'") as $report) {
	$value = unserialize($report["value"]);
	$data = ["value" => json_encode($value)];
	\system\Data::update([
		"data" => $data,
		"table" => "report",
		"where" => "id='" . $report["id"] . "'"
	]);
}
exit;
*/
?>

<form method="post" action="<?php echo \system\Core::query_path(0, -1);?>/case_and_sum?type=case&year=<?php echo $_GET["year"];?>&period=<?php echo $_GET["period"];?>">
<table border="1px" class="report">
	<tr>
		<th colspan="100%">
			<h3>Година: <?php echo $_GET["year"];?></h3>
			<h4>Период на справката: <?php echo $_GET["period"];?></h4>
		</th>
	</tr>

	<tr>
		<th>ВИДОВЕ ИЗПЪЛНИТЕЛНИ ДЕЛА</th>
		<th rowspan="3">шифър на реда</th>
		<th colspan="7">Движение на делата - кол. 3 = кол. 4 + кол. 5 + кол. 6 + кол. 7</th>
		<th colspan="5">Характер на изпълнението</th>
		<th colspan="2">Брой жалби</th>
	</tr>

	<tr>
		<th rowspan="2">РАВЕНСТВА: кол. 1 + кол. 2 = кол. 3 <br/> кол. 3 = кол.4 + кол. 5 + кол. 6 + кол. 7</th>
		<th rowspan="2">Несвършени дела в началото на отчетния период</th>
		<th rowspan="2">Постъпили</th>
		<th rowspan="2">Всичко/ кол. 1 + кол. 2/</th>
		<th colspan="2">Прекратени</th>
		<th rowspan="2">Изпратени на друг съдебен изпълнител</th>
		<th rowspan="2">Останали несвършени  в края на отчетния период</th>
		<th colspan="2">продажби на вещи</th>
		<th rowspan="2">Въводи</th>
		<th rowspan="2">Предаване на   движими   вещи</th>
		<th rowspan="2">Други</th>
		<th rowspan="2">Постъпили</th>
		<th rowspan="2">Уважени</th>
	</tr>

	<tr>
		<th>Свършени чрез реализиране на вземането</th>
		<th>По други причини</th>
		<th>Движими</th>
		<th>Недвижими</th>
	</tr>

	<tr>
		<th>a</th>
		<th>b</th>
		<?php for($b = 1; $b < 15; $b++){?>
		<th><?php echo $b;?></th>
		<?php } ?>
	</tr>

	<?php
	$array = array();
	$reversed = array_reverse($Caser->type(), true);
	foreach($reversed as $row => $name){
		$fields = $PDO->query("SELECT * FROM report WHERE year='" . $_GET["year"] . "' AND period='" . $_GET["period"] . "' AND type='case' AND row='" . $row . "'")->fetch();
		$array[$fields["row"]] = json_decode($fields["value"], true);
		$x = isset($array[$row]) ? $array[$row] : [];
		for($a = 1; $a < 15; $a++){
			if($a == 3){
				$x[3] = $x[1] + $x[2];
			} elseif($a == 7){
				$x[$a] = $x[3] - $x[4] - $x[5] - $x[6];
			} elseif($row == 1300){
				$x[$a] = $array[1310][$a] + $array[1320][$a] + $array[1330][$a] + $array[1340][$a] + $array[1400][$a];
			} elseif($row == 1200){
				$x[$a] = $array[1210][$a] + $array[1220][$a] + $array[1230][$a];
			} elseif($row == 1140){
				$x[$a] = $array[1150][$a] + $array[1160][$a];
			} elseif($row == 1110){
				$x[$a] = $array[1120][$a] + $array[1130][$a];
			} elseif($row == 1100){
				$x[$a] = $array[1110][$a] + $array[1140][$a] + $array[1170][$a];
			} elseif($row == 1000){
				$x[$a] = $array[1100][$a] + $array[1200][$a] + $array[1300][$a] + $array[1400][$a] + $array[1500][$a];
			} else {}
			$array[$row][$a] = $x[$a];
		}
	}

	$cis_names = array(1 => "DontFinish", 2 => "Enter", 4 => "Claim", 5 => "OtherReason", 6 => "OtherExecutor", 8 => "SaleMove", 9 => "SaleDontMove", 10 => "Induction", 11 => "ThingMove", 12 => "Other", 13 => "ComplaintEnter", 14 => "ComplaintExecution");
	$row_cnt = 0;
	foreach($Caser->type() as $row => $name){
		$row_cnt++;
		$x = $array[$row];
		?>
	<tr>
		<td><?php echo $name;?></td>
		<td><?php echo $row;?></td>
		<?php

		for($a = 1; $a < 15; $a++){?>
			<td class="<?php if($row == 1000 || $row == 1100 || $row == 1110 || $row == 1140 || $row == 1200 || $row == 1300 || $a == 3 || $a == 7){ echo 'color-3-bg text-center';}?>">
				<?php if($row == 1000 || $row == 1100 || $row == 1110 || $row == 1140 || $row == 1200 || $row == 1300 || $a == 3 || $a == 7){
					echo $x[$a];
				} else {
					if($_GET["period"] == "2"){
						$previous = $PDO->query("SELECT * FROM report WHERE type='case' AND period = '1' AND year='" . $_GET["year"] . "' AND row='" . $row ."'")->fetch()["value"];
						$row_data = json_decode($previous, true);
						$previous = isset($row_data[$a]) ? $row_data[$a] : 0;
						if($previous > 0 && $previous > $x[$a]){ echo $previous;}
					} else {
						$previous = 0;
					}
				?>
					<input type="number" class="report-cell" value="<?php echo isset($x[$a]) ? $x[$a] : 0;?>" name="<?php echo isset($_GET["fill"]) ? 'view:_id1:' .  $cis_names[$a] . '_' . $row_cnt : 'row_' . $row . '_' . $a;?>" <?php if($previous > 0 && $previous > $x[$a]){?> style="background-color: red;" <?php }?>/>
				<?php } ?>
			</td>
		<?php }?>
	</tr>
	<?php } ?>
</table>

<div class="text-center padding-30">
	<?php if(!isset($_GET["fill"])){ ?>
		<button type="button" class="button" onclick="window.open('<?php echo $_SERVER["REQUEST_URI"];?>&fill=true', '_self')">Попълване на отчет</button>
		<button class="button">Запази</button>
	<?php } ?>

	<button type="button" class="button" onclick="history.back();">Назад</button>
</div>
</form>

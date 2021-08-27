<form method="post" action="<?php echo $Core->query_path(0, -1);?>/case_and_sum?type=sum&year=<?php echo $_GET["year"];?>&period=<?php echo $_GET["period"];?>">
<table border="1px" class="report">
	<tr>
		<th colspan="100%">
			<h3>Година: <?php echo $_GET["year"];?></h3>
			<h4>Период на справката: <?php echo $_GET["period"];?></h4>
		</th>
	</tr>

	<tr>
		<th>ВИДОВЕ ИЗПЪЛНИТЕЛНИ ДЕЛА ПО ХАРАКТЕР И ПРОИЗХОД НА ВЗЕМАНИЯТА</th>
		<th rowspan="2">шифър на реда</th>
		<th colspan="3">Дължими суми по изп. дела</th>
		<th colspan="4">Събрана сума </th>
		<th rowspan="2">Несъбрани суми по опрощаване, прекр. по подс. перемция, изпратени на друг СИ, давност, обезсилване и др.</th>
		<th rowspan="2">Останала несъбрана сума по  изпълнителни листове в края на отчетния период</th>
	</tr>

	<tr>
		<th>РАВЕНСТВА: кол. 1 + кол. 2 = кол. 3 <br/> кол. 3 = кол. 7 + кол.8 + кол. 9 <br/> кол. 4 = кол. 5 + 6 + 7 <br/> кол. 9  ≤ кол. 4</th>
		<th>От образуването им до началото на отчетния период</th>
		<th>От образувани през отчетния период</th>
		<th>Всичко / кол. 1 + кол. 2/ <br/> /кол. 3 = кол. 7 + 8 + 9/</th>
		<th>О Б Щ О /кол.5+ 6+7/</th>
		<th>разноски</th>
		<th>Лихви</th>
		<th>Суми по изпълнителни листове</th>
	</tr>

	<tr>
		<th>a</th>
		<th>b</th>
		<?php for($b = 1; $b < 10; $b++){?>
		<th><?php echo $b;?></th>
		<?php } ?>
	</tr>

	<?php
	$array = array();
	$reversed = array_reverse($Caser->type(), true);
	foreach($reversed as $row => $name){
		$fields = $PDO->query("SELECT * FROM report WHERE year='" . $_GET["year"] . "' AND period='" . $_GET["period"] . "' AND type='sum' AND row='" . $row . "'")->fetch();
		$array[$fields["row"]] = unserialize($fields["value"]);
		$x = $array[$row];
		for($a = 1; $a < 10; $a++){
			if($a == 3){
				$x[3] = $x[1] + $x[2];
			}  elseif($a == 9){
				$x[$a] = $x[3] - $x[4] - $x[8];
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
				$x[$a] = $array[1100][$a] + $array[1200][$a] + $array[1300][$a] + $array[1400][$a];
			} elseif($a == 4){
				$x[$a] = $x[5] + $x[6] + $x[7];
			} else {}
			$array[$row][$a] = $x[$a];
		}
	}

	$cis_names = array(1 => "Sum1", 2 => "Sum2", 5 => "AddExpense", 6 => "Interest", 7 => "SumExecSheet", 8 => "Sum4", 9 => "Sum5");
	$row_cnt = 0;
	foreach($Caser->type() as $row => $name){
		$row_cnt++;
		$x = $array[$row];
		?>
	<tr>
		<td><?php echo $name;?></td>
		<td><?php echo $row;?></td>
		<?php

		for($a = 1; $a < 10; $a++){?>
			<td class="<?php if($row == 1000 || $row == 1100 || $row == 1110 || $row == 1140 || $row == 1200 || $row == 1300 || $a == 3 || $a == 4){ echo 'color-3-bg text-center';}?>">
				<?php if($row == 1000 || $row == 1100 || $row == 1110 || $row == 1140 || $row == 1200 || $row == 1300 || $a == 3 || $a == 4){
					echo number_format($x[$a], 2, ".", " ");
				} else {
					if($_GET["period"] == "2" && $a != 9){
						$previous = $PDO->query("SELECT * FROM report WHERE type='sum' AND period = '1' AND year='" . $_GET["year"] . "' AND row='" . $row ."'")->fetch()["value"];
						$previous = unserialize($previous)[$a];
						if($previous > 0 && $previous > $x[$a]){ echo $previous;}
					} else {
						$previous = 0;
					}
					$sum_value = isset($x[$a]) &&  $x[$a] != ""? $x[$a] : 0;
					if(isset($_GET["fill"])){ $sum_value = number_format($sum_value, 2, ",", "");}
				?>
					<input type="<?php echo $_GET["fill"] ? "text" : "number";?>" step="0.01" class="report-cell" value="<?php echo $sum_value;?>" name="<?php echo isset($_GET["fill"]) ? 'view:_id1:' .  ($row == 1310 ? "inputText" . $a : $cis_names[$a] . '_' . $row_cnt)  : 'row_' . $row . '_' . $a;?>" <?php if($previous > 0 && $previous > $x[$a]){?> style="background-color: red;" <?php }?>/>
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

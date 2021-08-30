<?php
$caser = array();
$sums = array();

$cnt = 0;
foreach($csv as $t){
	$case_sum = $t[3];
	$sums[] = $case_sum;
	$case = explode("/",$t[2]);
	$case_number = $case[0];
	$case_year = $case[1];
	#echo $a . '->' . $case_number . '<br/>';
	$caser[$case_year . (8820400000 + $case_number)][] = $case_sum;
}

ksort($caser);
$sums = array_unique($sums);
sort($sums);
$total = array();
$list = array();
?>
<table border="1px" cellpadding="5px">
<tr>
	<th>Дело</th>
	<?php foreach($sums as $sum){?>
	<th><?php echo $sum; $total[$sum] = 0; $list[$sum] = "";?></th>
	<?php }?>
</tr>

<?php
foreach($caser as $k=>$v){
	$split_number = $Caser->split_number($k);
?>
<tr>
	<td><?php echo $k;?></td>
	<?php foreach($sums as $sum){?>
	<td><?php if(in_array($sum, $v)){ echo $sum; $total[$sum] += $sum; $list[$sum][$split_number["year"]][] = $split_number["number"];}?></td>
	<?php }?>
</tr>
<?php }?>

<tr>
	<th><?php echo array_sum($total);?></th>
	<?php foreach($sums as $sum){?>
	<th><?php echo $total[$sum];?></th>
	<?php }?>
</tr>
</table>
Общо дела: <?php echo count($caser);?>

<table border="1px" cellpadding="5px">
<?php foreach($list as $k=>$v){?>
<tr>
	<td><?php echo $k;?></td>
	<td>
		<?php
			$cnt = 0;
			foreach($v as $year => $numbers){
				?>
					<b><?php echo $year . ":";?></b>
				<?php
				foreach($numbers as $number){
					echo $number . ",";
					++$cnt;
				}
				echo '<br>';
			}
		?>
	</td>
	<td><?php echo $cnt;?></td>
</tr>
<?php }?>
</table>

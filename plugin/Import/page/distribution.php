<?php
$sales = explode('"', $file);
$maxCreditors = 0;

for($a = 45; $a < count($sales); $a+=44){
	$creditors_string = $Import->clearEmpty($Import->removeOE($sales[$a + 16]));
	preg_match_all('/([0-9]*[.]?[0-9]+) лв. към ([^0-9]*)/', $creditors_string, $creditors);
	if($maxCreditors < count($creditors[1])){ $maxCreditors = count($creditors[1]);}
}

$colspan = 6 + ($maxCreditors * 2);
?>
<form method="post" action="<?php echo $Import->qwdir;?>/distribution" target="_blank">
	<table class="listTable" border="1px" cellpadding="0" cellspacing="0">

		<tr><th colspan="<?php echo $colspan;?>">Разпределения</th></tr>
		<tr>
			<th>Дело</th>
			<th>Дата</th>
			<th>Изготвено от</th>
			<th>Разпределена сума</th>
			<?php for($c = 0; $c < $maxCreditors; $c++){ ?>
				<th>Взискател <?php echo $c + 1;?></th>
				<th>Сума за <?php echo $c + 1;?></th>
			<?php } ?>
			<th>Общо за ЧСИ</th>
			<th>Т.26</th>
		</tr>

<?php
$cnt = 0;

/*
foreach($sales as $key=>$value){
	echo $key . '->' . $value . '<br>';
}
*/
//print_r($sales);

for($a = 45; $a < count($sales); $a+=44){

	++$cnt;
	$case_id = $Import->clearEmpty($Import->removeOE($sales[$a]));
	$date = $Import->clearEmpty($Import->removeOE($sales[$a + 2]));
	$user = $Import->clearEmpty($Import->removeOE($sales[$a + 4]));
	$distributed = $Import->clearEmpty($Import->removeOE($sales[$a + 6]));
	$creditors_string = $Import->clearEmpty($Import->removeOE($sales[$a + 16]));
	preg_match_all('/([0-9]*[.]?[0-9]+) лв. към ([^0-9]*)/', $creditors_string, $creditors);
	
	//print_r($creditors);
	$csiTotal = $Import->clearEmpty($Import->removeOE($sales[$a + 14]));
	$point = $Import->clearEmpty($Import->removeOE($sales[$a + 22]));
?>
		<tr>
			<td><input type="text" name="case_id<?php echo $cnt;?>" value="<?php echo $case_id;?>"/></td>
			<td><input type="text" name="date<?php echo $cnt;?>" value="<?php echo $date;?>"/></td>
			<td><input type="text" name="user<?php echo $cnt;?>" value="<?php echo $user;?>"/></td>
			<td><input type="text" name="distributed<?php echo $cnt;?>" value="<?php echo $distributed;?>"/></td>
			<?php
			$cred_array = array();			
			for($i = 0; $i < $maxCreditors; $i++){
					$creditor_name = isset($creditors[2][$i]) ? $creditors[2][$i] : null;
					$creditor_sum = isset($creditors[1][$i]) ? $creditors[1][$i] : null;
			?>
					<td><input type="text" name="<?php echo $i;?>creditor<?php echo $cnt;?>" value="<?php echo $creditor_name;?>"/></td>
					<td><input type="text" name="<?php echo $i;?>sum<?php echo $cnt;?>" value="<?php echo $creditor_sum;?>"/></td>
			<?php
			}
			
			?>
			<td><input type="text" name="csiTotal<?php echo $cnt;?>" value="<?php echo $csiTotal;?>"/></td>
			<td><input type="text" name="point<?php echo $cnt;?>" value="<?php echo $point;?>"/></td>
		</tr>
<?php } ?>

		<tr><td colspan="<?php echo $colspan;?>"><input type="submit" class="button" name="importDistributions" value="Запази"/></td></tr>
	<table>
</form>

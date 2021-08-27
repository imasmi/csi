<?php
$sales = explode('"', $file);
$maxCreditors = 0;

for($a = 41; $a < count($sales); $a+=40){
	$creditors = explode("лв.", $Import->clearEmpty($Import->removeOE($sales[$a + 14])));
	if($maxCreditors < count($creditors)){ $maxCreditors = count($creditors);}
}
$colspan = 6 + (($maxCreditors - 1) * 2);
?>
<form method="post" action="<?php echo $Import->qwdir;?>/distribution" target="_blank">
	<table class="listTable" border="1px" cellpadding="0" cellspacing="0">

		<tr><th colspan="<?php echo $colspan;?>">Разпределения</th></tr>
		<tr>
			<th>Дело</th>
			<th>Дата</th>
			<th>Изготвено от</th>
			<th>Разпределена сума</th>
			<?php for($c = 1; $c < $maxCreditors; $c++){ ?>
				<th>Взискател <?php echo $c;?></th>
				<th>Сума за <?php echo $c;?></th>
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
for($a = 41; $a < count($sales); $a+=40){

	++$cnt;
	$case_id = $Import->clearEmpty($Import->removeOE($sales[$a]));
	$date = $Import->clearEmpty($Import->removeOE($sales[$a + 2]));
	$user = $Import->clearEmpty($Import->removeOE($sales[$a + 4]));
	$distributed = $Import->clearEmpty($Import->removeOE($sales[$a + 6]));
	$creditors = explode("лв.", $Import->clearEmpty($Import->removeOE($sales[$a + 14])));
	array_pop($creditors);
	$csiTotal = $Import->clearEmpty($Import->removeOE($sales[$a + 16]));
	$point = $Import->clearEmpty($Import->removeOE($sales[$a + 18]));
?>
		<tr>
			<td><input type="text" name="case_id<?php echo $cnt;?>" value="<?php echo $case_id;?>"/></td>
			<td><input type="text" name="date<?php echo $cnt;?>" value="<?php echo $date;?>"/></td>
			<td><input type="text" name="user<?php echo $cnt;?>" value="<?php echo $user;?>"/></td>
			<td><input type="text" name="distributed<?php echo $cnt;?>" value="<?php echo $distributed;?>"/></td>
			<?php
			$cred_array = array();
			for($c = 0; $c < ($maxCreditors - 1); $c++){
				if($c < count($creditors)){
					$cred_data = explode(":", $creditors[$c]);
					$creditor_name = $Import->clearEmpty($Import->removeOE($cred_data[0]));
					$creditor_sum = $Import->clearEmpty($Import->removeOE($cred_data[1]));
			?>
					<td><input type="text" name="<?php echo $c;?>creditor<?php echo $cnt;?>" value="<?php echo $creditor_name;?>"/></td>
					<td><input type="text" name="<?php echo $c;?>sum<?php echo $cnt;?>" value="<?php echo $creditor_sum;?>"/></td>
			<?php
				} else { ?>
					<td></td>
					<td></td>
			<?php
				}
			}
			?>
			<td><input type="text" name="csiTotal<?php echo $cnt;?>" value="<?php echo $csiTotal;?>"/></td>
			<td><input type="text" name="point<?php echo $cnt;?>" value="<?php echo $point;?>"/></td>
		</tr>
<?php } ?>

		<tr><td colspan="<?php echo $colspan;?>"><input type="submit" class="button" name="importDistributions" value="Запази"/></td></tr>
	<table>
</form>

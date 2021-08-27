<?php if(strpos($fRow, "Ред статистика") === false){
?>
	<h1 class="text-center">Липсва Ред статистика</h1>
<?php echo '';
	exit;
};?>
<form method="post" action="<?php echo $Import->qwdir;?>/caser" target="_blank">
	<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
		
		<tr><th colspan="10">РЕГИСТЪР НА ЗАВЕДЕНИТЕ ДЕЛА</th></tr>
		<tr>
			<th>Изп. дело</th>	
			<th>Статус</th>
			<th>Ред статистика</th>
			<th>Титул</th>
			<th>Съд</th>
			<th>Дело съд</th>
			<th>Взискатели</th>
			<th>Длъжници</th>
			<th>Отговорник</th>
		</tr>

<?php
$cData = explode(' cursor: pointer;">', $file);

/*
for($b = 1; $b < count($cData); $b++){
	$rows = explode("\n", $cData[$b]);
	for($a = 0; $a < count($rows); $a++){
		echo $a;?> -> <?php echo $rows[$a];?><br/>
	}
}
*/

for($b = 0; $b < count($cData); $b++){
$rows = explode("\n", $cData[$b]);
for($a = 0; $a < count($rows); $a++){
	$case_number = $rows[$a]; // CASE NUMBER
	$case_status = rtrim(ltrim($Import->removeOE($Import->clearEmpty($rows[$a + 1])), '('),')');
	$case_data = explode('<ss:Data ss:Type="String">', $rows[$a + 8]); //CASE DATA
	$titul = explode('<br />', strip_tags($case_data[2], '<br>')); //CASE TITUL
	$vziskateli = explode('<p class="person', $case_data[4]); //CASE CREDITORS
	$dlujnici = explode('<p class="person', $case_data[5]); //CASE DEBTORS
	$charger = rtrim(ltrim($Import->removeOE($Import->clearEmpty($rows[$a + 2])), '('),')');

	if(isset($titul) && $titul[0] != ""){
?>
		<tr>
			<td><input type="text" name="case_number<?php echo $b . $a;?>" value="<?php echo $Import->removeOE($Import->clearEmpty($case_number));?>"/></td>
			<td><input type="text" name="statistic<?php echo $b . $a;?>" value="<?php echo $Import->removeOE($Import->clearEmpty($case_data[1]));?>"/></td>
			<td><input type="text" name="status<?php echo $b . $a;?>" value="<?php echo $case_status;?>"/></td>
			<td><input type="text" name="titul<?php echo $b . $a;?>" value="<?php echo $Import->removeOE($Import->clearEmpty($titul[0]));?>"/></td>
			<td><input type="text" name="court<?php echo $b . $a;?>" value="<?php echo $Import->removeOE($Import->clearEmpty(trim((isset($titul[1]))? $titul[1] : "", " ")));?>"/></td>
			<?php
			$list = (isset($titul[2])) ? rtrim($titul[2], '<br/>') : "";
			$list = explode("<br/>", $list);
			?>
			<td><input type="text" name="court_case<?php echo $b . $a;?>" value="<?php echo $Import->removeOE($Import->clearEmpty($list[0]));?>"/></td>
			<?php
			$people = ["creditor" => $vziskateli, "debtor" => $dlujnici];
			foreach ($people as $name => $values){
			?>
			<td>
			<?php
				unset($values[0]);
				$cnt = 1;
				foreach($values as $value){
					$vzisk = explode('<br/>', strip_tags($value, '<br>')); //CASE CREDITORS
			?>
					<ul>
						<?php $persName = explode('">', $vzisk[0]);?>
						<li><input type="text" name="<?php echo $name;?>Name<?php echo $b . $a . $cnt;?>" value="<?php echo $Import->removeOE($Import->clearEmpty($persName[1]));?>"/></li>
						<li>
						<?php
							if(strpos($vzisk[1], "ЕГН") !== false){ 
								$type="egn";
								$id = ltrim($vzisk[1], "ЕГН/ЕНЧ ");
								$selected_egn = "selected";
								$selected_eik = "";
							} else { 
								$type="eik";
								$id = ltrim($vzisk[1], "ЕИК ");
								$selected_eik = "selected";
								$selected_egn = "";
							}
						?>
							<select name="<?php echo $name;?>type<?php echo $b . $a . $cnt;?>">
								<option value="person" <?php echo $selected_egn;?>>ЕГН</option>
								<option value="firm" <?php echo $selected_eik;?>>ЕИК</option>
							</select>
						</li>
						<li><input type="text" name="<?php echo $name;?>id<?php echo $b . $a . $cnt;?>" value="<?php echo $Import->removeOE($Import->clearEmpty($id));?>"/></li>
					</ul>
					<?php
					$cnt++;
				}?>
			</td>
			<?php } ?>
			<td><input type="text" name="charger<?php echo $b . $a;?>" value="<?php echo $charger;?>"/></td>
		</tr>
	<?php } ?>
	<input type="hidden" name="vzisk_numb<?php echo $b . $a;?>" value="<?php echo count($vziskateli);?>"/>
	<input type="hidden" name="dlujnici_numb<?php echo $b . $a;?>" value="<?php echo count($dlujnici);?>"/>	
<?php } ?>
<?php } ?>
		<tr><td colspan="10" class="text-center"><input type="submit" class="center button" name="importCases" value="Запази"/></td></tr>
	</table>
</form>	

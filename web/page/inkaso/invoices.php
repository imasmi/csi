<?php 

$invoice = array();
foreach($PDO->query("SELECT * FROM invoice WHERE type='invoice' AND payer='4936' AND date > '2019-01-01' AND date < '2020-12-31' ORDER by date ASC") as $invoice){
	$case = $Query->select($invoice["case_id"], "id", "caser");
	$invoice[$case["number"]][] = array("invoice" => $invoice["invoice"], "sum" => $invoice["sum"], "date" => $invoice["date"]);
}



$list = file_get_contents($Core->doc_root() . "/web/page/inkaso/list.csv");
$rows = explode("\n", $list);
unset($rows[0]);
?>
<form method="post" id="kredit_invoice" action="<?php echo $Core->query_path();?>" onsubmit="return S.post('<?php echo $Core->query_path();?>', S.serialize('#kredit_invoice'))">
<input type="hidden" name="row" id="row" value="0"/>
<table border="1px" style="border-collapse: collapse;" cellpadding="3px">
	<tr>
		<th></th>
		<th>Длъжник</th>
		<th>Изп. дело №</th>
		<th>Банкова сметка</th>
		<th>Сума</th>
		<th>Дата на нареждане</th>
		<th>Информация за фактура</th>
		<th>Запази</th>
	</tr>
	
<?php
$cnt = 0;
$all = 0;
foreach($rows as $row){
	++$cnt;
	$search = explode(",", $row);
	
	$case_numb = explode("/", $search[1]);
	if(isset($case_numb[1])){
		$case = $case_numb[1] . (8820400000 + $case_numb[0]);
	} else {
		$case = $search[1];
	}
	
	?>
		<tr>
			<td><?php echo $cnt;?></td>
			<td><?php echo $search[0];?></td>
			<td><?php echo $case;?></td>
			<td><?php echo $search[2];?></td>
			<td><?php echo $search[3];?></td>
			<td><?php echo $search[4];?></td>
			
			<?php 
				if(isset($invoice[$case])){
					$match = array();
					
					$month = null;
					$text = explode("наредени на ", $search[4]);
					if(isset($text[1])){
						$date = explode(" ", $text[1]);
						$dates = explode(".", $date[0]);
						$date = $dates[2] . '-' . $dates[1] . '-' . $dates[0];
						$month = date("m.Y", strtotime($date));
					}
					
					foreach($invoice[$case] as $key => $invoice){
						if($invoice["sum"] == $search[3] && ($month == null || $month == date("m.Y", strtotime($invoice["date"])))){$match[] = $key;}
					}
					
					
					switch(count($match)){
						case 0:
							$color = "orange";
							break;
						case 1:
							$color = "green";
							break;
						default:
							$color = "yellow";
					}
					
					
					
					?>
					<td style="background-color: <?php echo $color;?>">
						<?php
						$finded = false;
						foreach($invoice[$case] as $key => $invoice){
							++$all;
							
							if(!empty($match) && in_array($key, $match)){
								$finded = true;
							?>
								<div class="invoice" id="invoice_<?php echo $all;?>">
									<button type="button" onclick="S.remove('#invoice_<?php echo $all;?>')">-</button>
									<?php echo $invoice["invoice"];?>/<?php echo date("d.m.Y", strtotime($invoice["date"]));?> за <?php echo $invoice["sum"];?> лева
									<input type="hidden" name="<?php echo $cnt;?>" value="<?php echo $invoice["invoice"];?>/<?php echo date("d.m.Y", strtotime($invoice["date"]));?> за <?php echo $invoice["sum"];?> лева"/>
								</div>
							<?php
							} 

							if($finded === false){
								?><input type="hidden" name="<?php echo $cnt;?>" value="?"/><?php
							}
						}
						?>
					</td>
					<?php
				} else {
				?>
				<td style="color: red">missing</td>
				<?php
				}
			?>
			<td><button class="button" onclick="S('#row').value='<?php echo $cnt;?>';">Save</button></td>
		</tr>
	<?php
}
?>
</table>
</form>
<?php
echo count($rows);
?>
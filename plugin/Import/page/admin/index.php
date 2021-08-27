<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
	<tr><th colspan="2">Последни импорти</th></tr>
<?php	
	$imports = array("Дела" => "caser", "Входящи документи" => "incomings", "Изходящи документи" => "outgoings", "Плащания" => "payment", "Фактури" => "invoice", "Разпределение (csv)" => "distribution");
	
	foreach($imports as $key => $value) {
		$lastImport = $Import->lastImport($value);
		$color = (date("Y-m-d", strtotime($lastImport)) == date("Y-m-d")) ? "green" : "red";
?>
		<tr style="background-color: <?php echo $color;?>">
			<th><?php echo $key;?></th>
			<td><?php echo $lastImport;?></td>
		</tr>
<?php	} ?>

</table>
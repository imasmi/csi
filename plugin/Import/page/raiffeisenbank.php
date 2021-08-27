<form method="post" >
	<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
		
		<tr><th colspan="8">Проверка на Райфайзенбанк</th></tr>
		<tr>
			<th></th>
			<th>Сума в лева</th>
			<th>Дата</th>
			<th>Наредител</th>
			<th>Получател</th>
			<th>Описание</th>
		</tr>
<?php
$bank = explode('<td', $import);

$cnt = 1;
$amm = 0;

for($a = 13; $a < (count($bank)); $a+=12){
	$creditor = $Import->clearEmpty($Import->clearBank($bank[$a]));
	$date = $Import->clearEmpty($Import->clearBank($bank[$a + 1]));
	$amount = $Import->clearEmpty($Import->clearBank($bank[$a + 3]));
	$debtor = $Import->clearEmpty($Import->clearBank($bank[$a + 8]));
	$description = $Import->clearEmpty($Import->clearBank($bank[$a + 9]));
?>
	<tr>
		<td><?php echo $cnt++;?></td>
		<td><?php echo $amount;?></td>
		<td><?php echo $date;?></td>
		<td><?php echo $debtor;?></td>
		<td><?php echo $creditor;?></td>
		<td><?php echo $description;?></td>
	</tr>
<?php
$amm+= $amount;
}
?>
	<tr>
		<td></td>
		<td><?php echo $amm;?></td>
		<td colspan="6"></td>
	</tr>

</table>
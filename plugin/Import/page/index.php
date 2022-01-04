<?php 
include_once(\system\Core::doc_root() . '/plugin/Import/php/Import.php');
$Import = new \plugin\Import\Import;
?>
<div class="text-center margin-60"><?php echo $Import->button("top");?></div>

<div class="admin">
	<table>
		<tr>
			<th>Дела</th>
			<td>xls (ред статистика!)</td>
		</tr>
		
		<tr>
			<th>Входящи</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>Изходящи</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>Протоколи</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>Изходящи</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>Плащания</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>Фактури</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>Разпределения</th>
			<td>csv</td>
		</tr>
		
		<tr>
			<th>БНБ</th>
			<td>xml</td>
		</tr>
		
		<tr>
			<th>Печат Юробанк</th>
			<td>xml</td>
		</tr>
		
		<tr>
			<th>Засечка Юробанк</th>
			<td>xls</td>
		</tr>
		
		<tr>
			<th>Отчет КЧСИ и МП</th>
			<td>csv</td>
		</tr>
	</table>
</div>
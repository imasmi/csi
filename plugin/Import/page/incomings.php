<?php 
	$names = $Import->fields()["incoming"];
	$numbers = $Import->numbers($names);
?>
<div class="admin">
	<form method="post" action="<?php echo $Import->qwdir;?>/incomings" target="_blank">
		<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
			
			<tr><th colspan="100%">Входящ регистър</th></tr>
			<tr>
				<?php foreach($names as $name){?>
					<th><?php echo $name;?></th>
				<?php } ?>
			</tr>
	<?php
	$a = 0;
	foreach($rows as $rowData){
		$row = $Import->row($rowData);
	?>	
			<tr>
				<?php foreach($numbers as $key => $number){?>
					<td><input type="text" name="<?php echo $key . '-' . $a;?>" value="<?php echo $row[$number];?>"/></td>
				<?php } ?>
			</tr>
	<?php 
		++$a;
	} ?>
			<tr><td colspan="8"><input type="submit" class="button" name="importProtocols" value="Запази"/></td></tr>
		</table>
		<input type="hidden" name="rows" value="<?php echo $a;?>"/>
	</form>
</div>

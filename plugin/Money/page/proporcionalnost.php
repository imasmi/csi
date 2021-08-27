<div class="admin">
	<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
		<tr>
			<th></th>
			<th>Сума за погасяване</th>
			<th><input type="number" id="sum" step="0.01" onchange="csi.proportions()"/></th>
			<th>Дълг</th>
			<th id="dept"></th>
		</tr>
		
		<tr>
			<th></th>
		<?php
		$sums = 4;
		for($a = 1; $a <= $sums; $a++){
		?>
		<input type="hidden" id="totalSums" value="<?php echo $sums;?>"/>
			<th><?php echo $a;?></th>
		<?php } ?>
		</tr>
		
		<tr>
			<td>Суми</td>
		<?php for($a = 1; $a <= $sums; $a++){ ?>
			<td><input type="number" id="sum<?php echo $a;?>" onchange="csi.proportions()" step="0.01"/></td>
		<?php } ?>
		</tr>
			
		<tr>
			<td>Метод умножение</td>
		<?php for($a = 1; $a <= $sums; $a++){ ?>
			<td id="multi<?php echo $a;?>"></td>
		<?php } ?>
		</tr>
		
		<tr>
			<td>Метод делене</td>
		<?php for($a = 1; $a <= $sums; $a++){ ?>
			<td id="division<?php echo $a;?>"></td>
		<?php } ?>
		</tr>
	</table>
</div>
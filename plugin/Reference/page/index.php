<div class="admin">
<div class="attention">Mozilla Firefox</div>
<form method="post" action="<?php echo $Core->this_path(0, -1);?>/list">
<table class="listTable" border="1px">
	<tr>
		<th>№</th>
		<th>Изп. дело<input type="submit" value="Submit" class="bnbCheckbox button"/></th>
		<th>Всички<br/><input type="checkbox" onchange="csi.checkStarters(this, 'red')"/></th>
		<th>НАП<br/><input type="checkbox" onchange="csi.checkStarters(this, 'nap')"/></th>
		<th>НОИ<br/><input type="checkbox" onchange="csi.checkStarters(this, 'noi')"/></th>
		<th>БНБ<br/><input type="checkbox" onchange="csi.checkStarters(this, 'bnb')"/></th>
		<th>ГРАО<br/><input type="checkbox" onchange="csi.checkStarters(this, 'grao')"/></th>
	</tr>
	<?php for($a = 1; $a < 101; $a++){?>
	<tr>
		<td><?php echo $a;?></td>
		<td><?php $Caser->select("case_" . $a, "finded_case_" . $a);?></td>
		<!--<td><input type="text" name="case_<?php echo $a;?>" onchange="csi.trim(this)"/></td>-->

		<th><input type="checkbox" onchange="S.checkAll(this, '.red_<?php echo $a;?>')" id="red_<?php echo $a;?>"/></th>
		<td>
			<input type="checkbox" name="nap_<?php echo $a;?>" id="nap_<?php echo $a;?>" class="red_<?php echo $a;?>"/>
			<select name="nap_type_<?php echo $a;?>" onchange="csi.napSpravki(this.value, '#nap_<?php echo $a;?>')">
				<option value="0">ВСИЧКИ</option>
				<option value="191">ДОПК 191</option>
				<option value="74">Член 74</option>
			</select>
		</td>
		<td><input type="checkbox" name="noi_<?php echo $a;?>" id="noi_<?php echo $a;?>" class="red_<?php echo $a;?>"/></td>
		<td><input type="checkbox" name="bnb_<?php echo $a;?>" id="bnb_<?php echo $a;?>" class="red_<?php echo $a;?>"/></td>
		<td><input type="checkbox" name="grao_<?php echo $a;?>" id="grao_<?php echo $a;?>" class="red_<?php echo $a;?>"/></td>
	</tr>
	<?php } ?>
</table>
<input type="hidden" name="redove" value="100"/>
</form>
</div>

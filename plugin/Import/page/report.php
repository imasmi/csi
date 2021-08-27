<?php
	$type = count(explode(',', $rows[1])) > 15 ? "case" : "sum";
?>
<div class="admin">
	<form  method="post" action="<?php echo $Core->this_path(0, -1);?>/query/report">
		<input type="hidden" name="rows" value='<?php echo serialize($rows);?>'/>
		<div class="title">ОТЧЕТ ЗА ДЕЙНОСТТА НА ЧСИ</div>
		<table class="admin">
			<tr>
				<td>Тип</td>
				<td>
					<?php $array = array("case" => "Изпълнителни дела", "sum" => "Суми");
						$Form->select("type", $array, array("select" => $type));
					?>
				</td>
			</tr>

			<tr>
				<td>Период</td>
				<td>
					<input name="date" type="date" value="<?php echo date("m-d") > "07-01" ? date("Y") . "-01-01" : date("Y") - 1 . "-07-01";?>"/>
				</td>
			</tr>

			<tr>
				<td colspan="2" class="text-center">
					<button class="button"><?php echo $Text->item("Save");?></button>
					<button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
				</td>
			</tr>
		</table>
	</form>
</div>

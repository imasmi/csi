<?php 
$case = $Query->select($_GET["case"], "id", "caser");
$person = $Query->select($_GET["person"], "id", "person");
?>
<div class="admin">
	<h2 class="text-center">СПРАВКА ТРУДОВИ ДОГОВОРИ</h2>
	<form>
		<table>
			<tr>
				<th>Идентификатор(с дължина от 6 до 16 символа)</th>
				<td><input class="form-control" name="ID" value="<?php echo $person["EGN_EIK"];?>"></td>
			</tr>
			
			<tr>
				<th>Вид на идентификатора</th>
				<td><igx-select-item class="igx-drop-down__item--selected">ЕГН</igx-select-item></td>
			</tr>
			
			<tr>
				<th>Филтър за трудови договори</th>
				<td><igx-select-item class="igx-drop-down__item--selected">Действащи трудови договори</igx-select-item></td>
			</tr>
			
			<tr>
				<th>Номер на преписка</th>
				<td><input class="text-box single-line" data-val="true" data-val-required="Полето Номер на преписка е задължително" name="serviceURI" type="text" value="<?php echo $case["number"];?>"></td>
			</tr>
			
			<!--<tr>
				<th>Тип на услугата</th>
				<td>
					<select class="form-control" data-val="true" data-val-required="Полето Тип на услугата е задължително" id="TaskService" name="TaskService"><option value="">- Изберете стойност от списъка -</option>
						<option value="1">За административна услуга</option>
						<option value="2" selected>За проверовъчна дейност</option>
					</select>
				</td>
			</tr>-->
			<tr><td colspan="100%" class="text-center"><button class="button margin-20" onclick="window.close()">CLOSE</button></td></tr>
		</table>
	</form>
</div>
	
	
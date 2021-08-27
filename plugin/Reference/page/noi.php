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
				<td><input class="form-control" id="Identity_ID" name="Identity.ID" value="<?php echo $person["EGN_EIK"];?>"></td>
			</tr>
			
			<tr>
				<th>Вид на идентификатора</th>
				<td>
					<select class="form-control valid" data-val="true" data-val-required="Полето Вид на идентификатора е задължително" id="Identity_TYPE" name="Identity.TYPE" aria-required="true" aria-describedby="Identity_TYPE-error" aria-invalid="false">
						<option value=""></option>
						<option value="Bulstat">БУЛСТАТ</option>
						<option value="EGN" selected>ЕГН</option>
						<option value="LNC">ЛНЧ</option>
						<option value="SystemNo">Сл. номер</option>
						<option value="BulstatCL">БУЛСТАТ(СЛ)</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<th>Филтър за трудови договори</th>
				<td>
					<select class="form-control" data-val="true" data-val-required="Полето Филтър за трудови договори е задължително" id="ContractsFilter" name="ContractsFilter">
						<option value=""></option>
						<option value="Active" selected>Действащи трудови договори</option>
						<option value="All">Всички трудови договори</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<th>Номер на преписка</th>
				<td><input class="text-box single-line" data-val="true" data-val-required="Полето Номер на преписка е задължително" id="ServiceURI" name="ServiceURI" type="text" value="<?php echo $case["number"];?>"></td>
			</tr>
			
			<tr>
				<th>Тип на услугата</th>
				<td>
					<select class="form-control" data-val="true" data-val-required="Полето Тип на услугата е задължително" id="TaskService" name="TaskService"><option value="">- Изберете стойност от списъка -</option>
						<option value="1">За административна услуга</option>
						<option value="2" selected>За проверовъчна дейност</option>
					</select>
				</td>
			</tr>
			<tr><td colspan="100%" class="text-center"><button class="button margin-20" onclick="window.close()">CLOSE</button></td></tr>
		</table>
	</form>
</div>
	
	
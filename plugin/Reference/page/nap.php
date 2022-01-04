<?php 
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($_GET["case"]);
?>
	
	<form name="decFrm" method="post" action="<?php echo \system\Core::query_path() . '?case=' . $_GET["case"] . '&person=' . $_GET["person"];?>">
		<table cellspacing="1" cellpadding="1" border="0" width="95%" class="form noborder" align="center">
		<tbody>
		<tr><td colspan="2">
			<table class="center padding-40">
				<tr>
					<td style="vertical-align: top;"><input type="checkbox" name="wait_nap"/> Чака НАП</td>
				</tr>
				<tr>
					<td style="vertical-align: top;">
						<input type="text" name="NAP_number" placeholder="Входящ № НАП"/>
						<input type="submit" name="saveExit" value="Пуснато"/>
					</td>
				</tr>
			</table>
		</td></tr>
			<tr><th align="center">НАЦИОНАЛНА АГЕНЦИЯ ЗА ПРИХОДИТЕ</th></tr>
			<tr><th align="center">ЕИК по БУЛСТАТ 131063188 </th></tr>
			<tr><td><table cellspacing="0" cellpadding="4" border="0" class="form noborder" style="width: 95%;" align="center">
		<tbody>
			<tr><td align="center" colspan="2"><span style="font-size: 16pt; font-weight: bold; color: rgb(34, 34, 51);"> ИСКАНЕ</span><br><span style="font-size: 14pt; font-weight: bold; color: rgb(34, 34, 51);">за издаване на документ</span></td></tr>
			<tr><td colspan="2"><p></p><center>от <input type="text" name="DocRequestPe_agent_name" value="ГЕОРГИ ЦЕНОВ ТАРЛЬОВСКИ" class="left" lang="cs" disabled="true"></center><i><center>(име, презиме и фамилия на съдебния изпълнител)</center></i><p></p></td></tr>
			<tr><td width="40%" class="readonly">ЕГН/ЛНЧ/Служебен № от регистъра на НАП</td><td><input type="text" name="DocRequestPe_agent_egn" value="" class="cell" id="P1_egn" lang="ve" style="width:124px" maxlength="10" disabled="true">
			&nbsp;Тип :&nbsp;
				<select name="DocRequestPe_agent_type" id="P1_type" onblur="isValidIdent(\'P1_egn\',\'P1_type\',0);" disabled>
					<option value="1">ЕГН</option>
					<option value="2">ЛНЧ</option>
					<option value="3">Сл.№</option>
				</select>
			</td></tr>
			<tr>
				<td class="readonly">ЕИК по БУЛСТАТ</td>
				<td><input type="text" name="DocRequestPe_agent_bulstat" value="6002021889" class="cell" id="P1_bulstat" lang="vb" style="width:160px" maxlength="13" disabled="true"></td>
			</tr>
			<tr>
				<td>Регистрационен №</td>
				<td><input type="text" name="DocRequestPe_agent_regno" value="882" class="cell" id="P1_regno" lang="pi" style="width:65px" maxlength="5"></td>
			</tr>
			<tr>
				<td class="readonly">Адрес по чл.8 от ДОПК</td>
				<td><input style="width: 450px;" type="text" name="DocRequestPe_agent_address" value="СОФИЯ СТОЛИЧНА гр. СОФИЯ 1172 ж.к. ДИАНАБАД бл. 2 ет.11 ап.55" class="left" lang="cs" disabled="true"></td>
			</tr>
			<tr>
				<td>Във връзка с изпълн.дело №</td>
				<td><input type="text" name="DocRequestPe_case_number" value="<?php echo $Caser->number;?>" lang="cs">, образувано въз основа на</td>
			</tr>
			<tr>
				<td>Изпълнителен лист издаден на</td>
				<td><input type="date" name="DocRequestPe_case_date" id="date1" onchange="csi.changeDate(this)" class="date" id="date1_display" align="top" value="<?php echo $Caser->title_main["date"];?>"></td>
			</tr>
			<tr>
		<?php	
				$main_vzisk = $Caser->creditor;	
				$creditor = $PDO->query("SELECT * FROM person WHERE id='" . $main_vzisk[0] . "'")->fetch();				
				
				if($creditor["type"] == "person"){
					$egn = $creditor["EGN_EIK"];
					$selected = "selected";
					$eik = "";
				} else {
					$egn = "";
					$selected = "";
					$eik = $creditor["EGN_EIK"];
				}
				
				$court = $Caser->title_main["court"];
				if($court == "СОФИЙСКИ ГРАДСКИ СЪД"){
					$court_type = "ГРАДСКИ";
					$court_name = "СОФИЯ";
				} elseif($court == "СОФИЙСКИ АПЕЛАТИВЕН СЪД"){
					$court_type = "АПЕЛАТИВЕН";
					$court_name = "СОФИЯ";
				} elseif(strpos($court, "ПАЗАРДЖИШКИ АДМИНИСТРАТИВЕН СЪД") !== false) {
					$titul = explode(' СЪД ', $case["court"]);
					$court_type = "АДМИНИСТРАТИВЕН";
					$court_name = "ПАЗАРДЖИК";
				} elseif(strpos($court, " СЪД ") !== false) {
					$titul = explode(' СЪД ', $court);
					$court_type = $titul[0];
					$court_name = $titul[1];
				} else {
					$titul = explode(' ', $creditor["name"]);
					$court_type = $titul[0];
					$court_name = $titul[1];
				}				
		?>					
									
				<td>От</td>
				<td>
					<input type="text" name="DocRequestPe_case_type" value="<?php echo $court_type;?>" lang="cs">
					&nbsp;СЪД&nbsp;
					<input type="text" name="DocRequestPe_case_court" value="<?php echo $court_name;?>" lang="cs">
										</td>
			</tr>	
			<tr>
				<td>По молба на</td>
				<td><input style="width: 300px;" type="text" name="DocRequestPe_requester_name" value="<?php echo $creditor["name"];?>" class="left" lang="cs"><center><i>(име/наименование на лицето)</i></center></td>
			</tr>
		<?php		
			
		?>		
			<tr>
				<td>ЕГН/ЛНЧ/Служебен № от регистъра на НАП</td>
				<td>
					<input type="text" name="DocRequestPe_requester_egn" value="<?php echo $egn;?>" class="cell" id="P2_egn" lang="pi" style="width:124px" maxlength="10" onblur="isValidEGNLnch(this,\'P2_type\');">
					&nbsp;Тип&nbsp;
					<select name="DocRequestPe_requester_type" onblur="isValidIdent(\'P2_egn\',\'P2_type\');" id="P2_type">
						<option value=""></option>
						<option value="1"  <?php echo $selected;?>>ЕГН</option>
						<option value="2">ЛНЧ</option>
						<option value="3">Сл.№</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>ЕИК по БУЛСТАТ/ЕИК по ЗТР</td>
				<td><input type="text" name="DocRequestPe_requester_bulstat" value="<?php echo $eik;?>" class="cell" id="P2_bulstat" lang="vb" style="width:160px" maxlength="13"></td>
			</tr>
			<?php
				$debtor = $PDO->query("SELECT * FROM person WHERE id='" . $_GET["person"] . "'")->fetch();
				if($debtor["type"] == "person"){
					$egn = $debtor["EGN_EIK"];
					$selected = "selected";
					$eik = "";
				} else {
					$egn = "";
					$selected = "";
					$eik = $debtor["EGN_EIK"];
				}
			?>					
									
			<tr>
				<td>срещу длъжника</td>
				<td><input type="text" style="width: 300px;" name="DocRequestPe_debtor_name" value="<?php echo $debtor["name"];?>" class="left" lang="cs"><center><i>(име/наименование на лицето)</i></center></td>
			</tr>
			<tr>
				<td>ЕГН/ЛНЧ/Служебен № от регистъра на НАП</td>
				<td>
					<input type="text" name="DocRequestPe_debtor_egn" value="<?php echo $egn;?>" class="cell" id="P3_egn" lang="pi" style="width:124px" maxlength="10" onblur="isValidEGNLnch(this,\'P3_type\');">
					&nbsp;Тип&nbsp;
					<select name="DocRequestPe_debtor_type" onblur="isValidIdent(\'P3_egn\',\'P3_type\');" id="P3_type">
						<option value=""></option>
						<option value="1" <?php echo $selected;?>>ЕГН</option>
						<option value="2">ЛНЧ</option>
						<option value="3">Сл.№</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>ЕИК по БУЛСТАТ/ЕИК по ЗТР</td>
				<td><input type="text" name="DocRequestPe_debtor_bulstat" value="<?php echo $eik;?>" class="cell" id="P2_bulstat" lang="vb" style="width:160px" maxlength="13"></td>
			</tr>
			<tr>
				<td>Адрес по чл.8 от ДОПК</td>
				<td><input type="text" name="DocRequestPe_debtor_address" value="" class="left" lang="cs"></td></tr></tbody></table></td>
			</tr>
		</tbody>
		</table>
		<p></p>
		<center><span style="font-weight: bold;">Моля да ми бъде издаден документ, съдържащ информация за описаното по-горе лице - длъжник, във връзка с разпоредбите :</span></center>
		<p></p>
			<table cellspacing="0" cellpadding="4" border="0" width="95%" class="form noborder" align="center">
			<tbody>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);" width="3%">
						<input type="hidden" value="149" name="DocRequestPe_docs_docenum[1]_id">
						<input type="hidden" value="d1" name="DocRequestPe_docs_docenum[1]_fields_field[1]_name">
			<?php $dopk = ($_GET["type"] != "74") ? "checked" : "";?>
						<input type="checkbox" name="DocRequestPe_docs_docenum[1]_fields_field[1]_value" id="d1" class="checkbox" <?php echo $dopk;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);">
						<label for="d1">на чл.191, ал. 4 от ДОПК</label>
					</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);" width="3%">
						<input type="hidden" value="145" name="DocRequestPe_docs_docenum[2]_id">
						<input type="hidden" value="d2" name="DocRequestPe_docs_docenum[2]_fields_field[1]_name">
			<?php $chlen = ($_GET["type"] != "191") ? "checked" : "";?>	
			<?php $disabled = ($_GET["type"] == "191") ? "disabled" : "";?>	
						<input type="checkbox" name="DocRequestPe_docs_docenum[2]_fields_field[1]_value" id="d2" class="checkbox" onclick="csi.click74(this);" <?php echo $chlen;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);">
						<b>на чл.74, ал.1, т.4 от ДОПК с информация отностно : </b> 
					</td></tr><tr><td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="701" name="DocRequestPe_docs_docenum[3]_id">
						<input type="hidden" value="d3" name="DocRequestPe_docs_docenum[3]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[3]_fields_field[1]_value" id="d3" class="checkbox" <?php echo $chlen;?> <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);">
						<label for="d3">Притежавани недвижими имоти</label>
					</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="702" name="DocRequestPe_docs_docenum[4]_id"><input type="hidden" value="d4" name="DocRequestPe_docs_docenum[4]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[4]_fields_field[1]_value" id="d4" class="checkbox" <?php echo $chlen;?> <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);"><label for="d4">Притежавани движими имоти</label></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="703" name="DocRequestPe_docs_docenum[5]_id">
						<input type="hidden" value="d5" name="DocRequestPe_docs_docenum[5]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[5]_fields_field[1]_value" id="d5" class="checkbox" <?php echo $chlen;?> <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);">
						<label for="d5">Декларирани доходи за последната изтекла данъчна година</label>
					</td>
				</tr>
				<?php if($debtor["type"] == 'person' && $_GET["type"] != "191"){ $checked = 'checked';} else { $checked = '';}?>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="704" name="DocRequestPe_docs_docenum[6]_id">
						<input type="hidden" value="d6" name="DocRequestPe_docs_docenum[6]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[6]_fields_field[1]_value" id="d6" class="checkbox" <?php echo $checked;?> <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);">
						<label for="d6">Трудови договори /само за ФЛ/</label>
					</td>
				</tr>
									
				<?php if($debtor["type"] == 'firm' && $_GET["type"] != "191"){ $checked = 'checked';} else { $checked = '';}?>
									
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="705" name="DocRequestPe_docs_docenum[7]_id">
						<input type="hidden" value="d7" name="DocRequestPe_docs_docenum[7]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[7]_fields_field[1]_value" id="d7" class="checkbox" <?php echo $checked;?> <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);"><label for="d7">Банкови сметки /само за ЮЛ/</label></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="706" name="DocRequestPe_docs_docenum[8]_id">
						<input type="hidden" value="d8" name="DocRequestPe_docs_docenum[8]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[8]_fields_field[1]_value" id="d8" class="checkbox" <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);"><label for="d8">Съдружник в търговско дружество</label></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 30px;">
						<input type="hidden" value="707" name="DocRequestPe_docs_docenum[9]_id">
						<input type="hidden" value="d9" name="DocRequestPe_docs_docenum[9]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[9]_fields_field[1]_value" id="d9" class="checkbox" <?php echo $chlen;?> <?php echo $disabled;?>>
					</td>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204);"><label for="d9">Данни за осигуряване, осигурител</label></td>
				</tr>
				<tr>
					<td align="left" width="3%" style="padding-left: 30px;">
						<input type="hidden" value="100" name="DocRequestPe_docs_docenum[10]_id">
						<input type="hidden" value="c1" name="DocRequestPe_docs_docenum[10]_fields_field[1]_name">
						<input type="checkbox" name="DocRequestPe_docs_docenum[10]_fields_field[1]_value" id="c1" class="checkbox" onclick="copyDoc();" <?php echo $disabled;?>>
					</td><td align="left"><label for="c1">Копие на документ</label></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); padding-left: 40px" colspan="2">
						<table border="0">
							<tr>
								<td align="left">
									<input type="hidden" value="101" name="DocRequestPe_docs_docenum[11]_id">
									<input type="hidden" value="c2" name="DocRequestPe_docs_docenum[11]_fields_field[1]_name">
									<input type="radio" name="DocRequestPe_docs_docenum[11]_fields_field[1]_value" value="true" id="c2" onclick="isDec();" disabled="">
								</td>
								<td align="left" colspan="2">
									<label for="c2">Декларация</label></td></tr><tr><td align="left" colspan="3" style="padding-left:30px">
									<table border="0">
										<tr>
											<td>Вид :</td>
											<td>
												<input type="hidden" value="c2_1" name="DocRequestPe_docs_docenum[12]_fields_field[1]_name">
												<select id="c2_1" class="disabled" disabled="" name="DocRequestPe_docs_docenum[12]_fields_field[1]_value"><option value=""></option>
													<option value="545">ЗКПО - годишна декларация</option>
													<option value="549">ЗДДФЛ - годишна декларация</option>
												</select>
												&nbsp;вх. № :&nbsp;
												<input type="hidden" value="c2_2" name="DocRequestPe_docs_docenum[12]_fields_field[2]_name" maxlength="100">
												<input type="text" id="c2_2" name="DocRequestPe_docs_docenum[12]_fields_field[2]_value" class="disabled" value="" readonly="">
											</td>
										</tr>
										<tr>
											<td>Дата :</td>
											<td>
												<input type="hidden" value="c2_3" name="DocRequestPe_docs_docenum[12]_fields_field[3]_name">
												<input type="hidden">
												<input type="date" class="disabled" onclick="return showCal(this, \'date2\',dateset);" onkeydown="return clearDateValue(this,event);" align="top" readonly="" name="DocRequestPe_docs_docenum[12]_fields_field[3]_value" value="" id="date2">
												&nbsp;Период :&nbsp;
												<input type="hidden" value="c2_4" name="DocRequestPe_docs_docenum[12]_fields_field[4]_name" maxlength="200">
												<input type="text" id="c2_4" name="DocRequestPe_docs_docenum[12]_fields_field[4]_value" class="disabled" value="" readonly="">
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="left">
									<input type="hidden" value="102" name="DocRequestPe_docs_docenum[13]_id"><input type="hidden" value="c3" name="DocRequestPe_docs_docenum[13]_fields_field[1]_name">
									<input type="radio" name="DocRequestPe_docs_docenum[13]_fields_field[1]_value" value="true" id="c3" onclick="isYearReport();" disabled=""></td>
								<td align="left">
									<label for="c3">Годишен отчет за дейността за година</label>
								</td>
								<td align="left">
									<input type="hidden" value="c3_1" name="DocRequestPe_docs_docenum[14]_fields_field[1]_name">
									<input type="text" lang="pi" id="c3_1" name="DocRequestPe_docs_docenum[14]_fields_field[1]_value" width="90%" class="disabled" maxlength="4" value="" readonly="">
									<input type="hidden" value="c3_2" name="DocRequestPe_docs_docenum[15]_fields_field[1]_name">
									<input type="hidden" value="712" name="DocRequestPe_docs_docenum[15]_fields_field[1]_value">
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</form>

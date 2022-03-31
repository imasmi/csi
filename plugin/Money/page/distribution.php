<?php 
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Pay.php');
?>
<div class="csi admin">
	<input type="time" id="start-time" value="<?php echo isset($_GET["start_time"]) ? $_GET["start_time"] : date("H:i:s");?>"/>
	<button type="button" class="button" onclick="window.open(location.href + (location.href.indexOf('?') === -1 ? '?' : '&') +'start_time=' + S('#start-time').value, '_self')">Промени начален час</button>
<form method="post" action="<?php echo \system\Core::query_path();?>" onsubmit="return csi.checkLenght()" onkeypress="return event.keyCode != 13;" target="_blank">
<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
	<tr>
		<th><input type="checkbox" onclick="S.checkAll(this, '.distribution')" checked/></th>
		<th>!</th>
		<th>Дело</th>
		<th>Получател</th>
		<th class="iban">IBAN</th>
		<th>Сума</th>
		<th>Основание</th>
		<th>Длъжник</th>
		<th>ЕГН/ЕИК</th>
		<th>№ документ</th>
		<th>Дата документ</th>
	</tr>
<?php
$creditorsSum = 0;
$csiSum = 0;
$start = (isset($_GET["start"]) ? $_GET["start"] : date("Y-m-d"));
$start_time = (isset($_GET["start_time"]) ? $_GET["start_time"] : "00:00:00");
$end = isset($_GET["end"]) && $_GET["end"] != "" ? $_GET["end"] : $start;

?>
<input type="hidden" name="start_date" value="<?php echo $start;?>"/>
<input type="hidden" name="start_time" value="<?php echo $start_time;?>"/>
<input type="hidden" name="end_date" value="<?php echo $end;?>"/>
<?php
$a = 1;
foreach($PDO->query("SELECT * FROM caser c, distribution d WHERE d.case_id=c.id AND d.user='2' AND d.date >= '" . $start . " " . $start_time . "' AND d.date <= '" . $end . " 23:59:59' ORDER by d.id ASC") as $distribution){
// CASE DEBTORS
	$Caser = new \plugin\Caser\Caser($distribution[0]);
	$case_debtors = $Caser->debtor;
	$heir = 0;
	if(count($case_debtors) == 1){
		$debtor = $PDO -> query("SELECT * FROM person WHERE id=" . $case_debtors[0])->fetch();
		$debtor_color = "";
	} else {
		$pay_invoice = $PDO->query("SELECT * FROM invoice WHERE date >= '" . $start . "' AND date <= '" . $end . "' AND case_id='" . $distribution["case_id"] . "' ORDER by type DESC");
		if($pay_invoice->rowCount() > 0){
			$deb_invoice = $pay_invoice->fetch();
			foreach($case_debtors as $debt){
				$deb_data = $PDO->query("SELECT * FROM person WHERE id='" . $debt . "'")->fetch();
				if($deb_data["id"] == $deb_invoice["payer"]){ $debtor = $deb_data;}
			}
			$debtor_color = "color-1-bg";
		
			$main_debtor = $PDO -> query("SELECT * FROM person WHERE id=" . $case_debtors[0])->fetch();
			$heir = 1;
		} else {
			$debtor = $PDO -> query("SELECT * FROM person WHERE id=" . $case_debtors[0])->fetch();
			$debtor_color = "color-1-bg";
		}
	}
	
//CREDITORS PAYMENTS
	$creditor_sums = json_decode($distribution["creditors"], true);
	if(is_array($creditor_sums)){
	foreach($creditor_sums as $creditors){
		foreach($creditors as $creditor_id => $sum){
		if($creditor_id != 0){
			$creditor = $PDO->query("SELECT * FROM person WHERE id='" . $creditor_id . "'")->fetch();
			$creditor_name = $creditor["name"];
			$creditorID = $creditor["id"];
		} else {
			$creditor_name = "";
			$creditorID = 0;
		}
		
		if($sum == 0){
			$rowClass = 'emptyROW';
		} elseif($creditor["budget"] == 1){
			$rowClass = 'budgetROW';
		} else {
			$rowClass = "directROW";
		}
	?>	
		<input type="hidden" name="caseID<?php echo $a;?>" value="<?php echo $distribution[0];?>"/>
		<tr class="<?php echo $rowClass;?>">
			<td><?php echo $distribution["id"];?>
				<?php $type = ($creditorID != 0 && $creditor["budget"] == 1) ? "budget" : "direct";?>
				<input type="checkbox" name="payment<?php echo $a;?>" class="distribution" id="payment<?php echo $a;?>" <?php echo (($sum > 0 && $type=='direct') ? "checked" : "");?>/>
				<input type="hidden" name="type<?php echo $a;?>" id="type<?php echo $a;?>" value="<?php echo $type;?>"/>
			</td>
			<td id="notes<?php echo $distribution["case_id"];?>"><?php \plugin\Note\Note::_(" WHERE (case_id=" . $distribution["case_id"] . " OR person_id='" . $creditorID . "') AND payment=1 AND hide is NULL", $distribution["case_id"], "payment", "#notes" . $distribution["case_id"]);?></td>
			<td>
				<?php echo $Caser->open();?>
				<?php if($distribution["user"] != 2){?><div style="color: red"><?php echo $PDO->query("SELECT email FROM " . $User->table . " WHERE id='" . $distribution["user"] . "'")->fetch()["email"];?></div><?php } ?>
			</td>
			
			<?php
			if($creditorID == "3348"){
				$cName = "ТД НАП ПЛОВДИВ, ОФИС ПАЗАРДЖИК";
			} elseif($creditorID == "3648"){
				$cName = "БНП ПАРИБА ПЪРСЪНЪЛ ФАЙНЕНС С. А.";
			} else {
				$cName = $creditor_name;
			}
			?>
			<td><input type="text" name="name<?php echo $a;?>" id="name<?php echo $a;?>" value="<?php echo $cName;?>"/>
			<?php
			$creditorsSum += $sum;
			if($distribution["transfered"] == "yes"){
			?>
				<img id="correct" <?php echo $this->pic(80);?>
			<?php } ?>
			</td>
			
			<?php
			
			$express_bank_check = $PDO->query("SELECT id FROM bank WHERE person_id='" . $creditorID . "' AND bank_unit = '14'");
			if($express_bank_check->rowCount() > 0){
				?>
					<div class="important">Лицето има банкови сметки в ЕКСПРЕСБАНК. Банкови преводи към ЕКСПРЕСБАНК вече не са разрешени, да проверя за нова банкова сметка.</div>
				<?php
			}
			
			if($type == "budget"){
				echo \plugin\Money\Pay::budgetPay($creditorID, $creditor_name, $a, $sum, $debtor["EGN_EIK"], $distribution);
			} else {
				$bank = $PDO -> query("SELECT * FROM bank WHERE person_id='" . $creditorID . "'");
				$chooseBank = ($bank->rowCount() > 1) ? 'class="color-1-bg"' : '';
			?>
				<td>
					<select name="bank<?php echo $a;?>" <?php echo $chooseBank;?> required>
						<option value="">Избери</option>
					<?php 
						foreach($bank as $bank){
						$selected = $distribution["prefBANK"] == $bank["id"] ? "selected" : "";
					 ?>
						<option value="<?php echo $bank["id"];?>" <?php echo $selected;?>><?php echo $bank["IBAN"];?></option>
					<?php } ?>
					</select>
				</td>
				<td><input type="text" name="amount<?php echo $a;?>" id="amount<?php echo $a;?>" value="<?php echo $sum;?>" readonly/></td>
			<?php
			}
			?>
			<td>
			<?php
	/* DESCRIPTION - АКО Е ЗА СЪДА ИЛИ МВР Е ЕДНО, ако е друго бюджетно е за всяко индивидуално, ако е директно плащане е стандартно */			
			if(strpos($creditor_name, 'СЪД') !== false || strpos($creditor_name, 'МВР') !== false){
				$description = \plugin\Money\Pay::caserNumbersDescription($distribution, $creditor_name);
			?>
				<textarea name="description<?php echo $a;?>" id="description<?php echo $a;?>" class="<?php echo $debtor_color;?>" maxlength="70"><?php echo  $description;?></textarea>
			<?php
			} elseif($type != "budget") {
				$desc_start = ($creditor_name != "" && $heir == 1 && ($creditor["id"] == "3648" || $creditor["id"] == "4936" || $creditor["id"] == "3370")) ? $main_debtor["EGN_EIK"] . ' ' . $Pay->splitName($main_debtor["name"]) : $debtor["EGN_EIK"] . ' ' . $Pay->splitName($debtor["name"]);
				$caseNumb = $Caser->split_number($distribution["number"]);
				$description = $desc_start . ' ИД ' . $caseNumb["number"] . '/' . $caseNumb["year"] . ' г.';
			?>
				<textarea name="description<?php echo $a;?>" id="description<?php echo $a;?>" class="<?php echo $debtor_color;?>" maxlength="70"><?php echo  $description;?></textarea>
			<?php } ?>
			</td>
			
			<?php if($creditorID != 0 && $creditor["budget"] == 1){ ?>
				<td><input type="text" name="debtor<?php echo $a;?>" id="debtor<?php echo $a;?>" value="<?php echo $debtor["name"];?>" maxlength="70"/></td>
				<td>
					<input type="text" name="egn<?php echo $a;?>" id="egn<?php echo $a;?>" value="<?php echo $debtor["EGN_EIK"];?>" maxlength="70" class="budgetAmount"/>
					<input type="hidden" name="egn_type<?php echo $a;?>" id="egn_type<?php echo $a;?>" value="<?php echo $debtor["type"];?>"/>
				</td>
				<?php $napHidden = ($creditor["nap"] == 0) ? "hidden" : "text";?>
				<td><input type="<?php echo $napHidden;?>" name="document<?php echo $a;?>" id="document<?php echo $a;?>" maxlength="70" class="budgetAmount"/></td>
				<?php $dateHidden = ($creditor["nap"] == 0) ? "hidden" : "date";?>
				<td><input type="<?php echo $dateHidden;?>" name="doc_date<?php echo $a;?>" value="<?php echo date("Y-m-d");?>" onchange="csi.changeDate(this)"/></td>
			<?php } else { ?>
				<th colspan="4"></th>
			<?php } ?>
		</tr>
		<?php
		$a++;
		}
	}
	}
	
	foreach($PDO->query("SELECT * FROM invoice WHERE date >= '" . $start . "' AND date <= '" . $end . "' AND case_id='" . $distribution["case_id"] . "' ORDER by type DESC") as $bill){		
	$billType = ($bill["type"] == "invoice") ? "Фактура" : "Сметка";
	?>
	<tr class="directROW">
		<td>
			<input type="checkbox" class="distribution" name="payment<?php echo $a;?>" id="payment<?php echo $a;?>" checked/>
			<input type="hidden" name="type<?php echo $a;?>" id="type<?php echo $a;?>" value="direct"/>
		</td>
		<td>
			<?php $Caser->open();?>
			<?php
				$csiSum += $bill["sum"];
			?>
		</td>
		<td><?php echo $billType;?></td>
		<td><input type="text" name="name<?php echo $a;?>" id="name<?php echo $a;?>" value="ЧСИ ГЕОРГИ ЦЕНОВ ТАРЛЬОВСКИ" readonly/></td>
		<td>
			<select name="bank<?php echo $a;?>">
				<option value="8" selected>BG38BPBI79301033376201</option>
			</select>
		</td>
		<td><input type="text" name="amount<?php echo $a;?>" id="amount<?php echo $a;?>" value="<?php echo $bill["sum"];?>" readonly/></td>
		<td><input type="text" name="description<?php echo $a;?>" id="description<?php echo $a;?>" value="<?php echo $billType;?> <?php echo $bill[$bill["type"]];?> <?php echo $debtor["name"];?>" maxlength="70"/></td>
		<th colspan="4"></th>
	</tr>
	<?php
	$a++;
	}
}
?>
<input type="hidden" name="totalPayments" id="totalPayments" value="<?php echo $a;?>"/>

	<tr>
		<th colspan="3">Общо: <?php echo number_format($csiSum + $creditorsSum, 2, '.', ',');?> лв.</th>
		<th colspan="2">За взискатели: <?php echo number_format($creditorsSum, 2, '.', ',');?> лв.</th>
		<th colspan="2">За ЧСИ: <?php echo number_format($csiSum, 2, '.', ',');?> лв.</td>
		<th>
			<select name="type" onchange="csi.markChecked(this.value)">
				<option value="directPay">Direct</option>
				<option value="budgetPay">Budget</option>
			</select>
		</th>
		<th colspan="4"><input type="submit" value="Създай файл" class="button"/></th>
	</tr/>
</table>
</form>
</div>

<?php
namespace plugin\Money;

class pay{
	public static function splitName($names){
		$name = explode(" ", $names);
		$newName = $name[0];
		
		if(isset($name[2])){
			$newName .= " " . $name[2];
		} elseif(isset($name[1])){
			$newName .= " " . $name[1];
		}
		return $newName;
	}
	
	public static function open_sledene($creditor){
		return '<a href="' . $GLOBALS["Page"]->url(21) . '?creditor=' . $creditor . '" target="_blank">Следене за плащания</a>';
	}
	
	public static function sledene($case_id, $months=6){
		$pay = $GLOBALS["PDO"]->query("SELECT date FROM distribution WHERE case_id='" . $case_id . "' ORDER by date DESC")->fetch();
		$nap = $GLOBALS["PDO"]->query("SELECT date FROM document WHERE case_id='" . $case_id . "' AND name='15' ORDER by date DESC")->fetch();
		$noi = $GLOBALS["PDO"]->query("SELECT date FROM document WHERE case_id='" . $case_id . "' AND (name='30' OR name='93' OR name='280') ORDER by date DESC")->fetch();
		$bnb = $GLOBALS["PDO"]->query("SELECT date FROM document WHERE case_id='" . $case_id . "' AND name='222' ORDER by date DESC")->fetch();
		
		$period = strtotime("-" . $months . " months");
		$napstr = strtotime($nap["date"]);
		$bnbstr = strtotime($bnb["date"]);
		$noistr = strtotime($noi["date"]);
		
		$checked = 0;
		if($napstr > $period){$checked++;}
		if($bnbstr > $period){$checked++;}
		if($noistr > $period){$checked++;}
		
		if(strtotime($pay["date"]) > $period){
			$color = "color1bg";
		} elseif($checked >= 2){
			$color = "color3bg";
		} elseif($checked > 0){
			$color = "color4bg";
		} else {
			$color = "color2bg";
		}
		return array("date" => $pay["date"], "nap" => $nap["date"], "noi" => $noi["date"], "bnb" => $bnb["date"], "color" => $color);		
	}

	public static function caserNumbersDescription($distribution, $creditor_name){
		if(strpos($creditor_name, "ТД НАП ПЛОВДИВ") === false){
			include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
			$Caser = new \plugin\Caser\Caser($distribution["case_id"]);
			$casEND = substr($distribution["number"], -5);
			$casEND = ltrim($casEND, "0");
			return ',' .  str_replace("№", "", $Caser->title_main["number"]) . 'г,ИД ' . $casEND . '/' . substr($distribution["number"], 0, 4) . 'г';
		} else {
			return ', ИД ' . $distribution["number"];
		}
	}
	public static function budgetPay($creditorID, $creditor_name, $a, $sum, $egn, $distribution){
		$accounts = $GLOBALS["PDO"]->query("SELECT * FROM bank WHERE person_id=" .$creditorID . " ORDER by id ASC");
		?>
		<td class="iban">
		<input type="hidden" name="amount<?php echo $a;?>" id="amount<?php echo $a;?>" value="<?php echo $sum;?>"/>
		<input type="hidden" name="rows<?php echo $a;?>" id="rows<?php echo $a;?>" value="<?php echo ($accounts->rowCount() + 1);?>"/>		
		<?php
		$accounts = $GLOBALS["PDO"]->query("SELECT * FROM bank WHERE person_id=" .$creditorID . " ORDER by id ASC");
		$n = 1;
		foreach($accounts as $bank){ ?>
			<div class="budgetIBAN">
				<div class="inline-block vertical-middle"><input type="checkbox" name="<?php echo $n . '_budget_check' . $a;?>" id="<?php echo $n . '_budget_check' . $a;?>" onchange="csi.usePay('<?php echo $n;?>','<?php echo $a;?>',this, '<?php echo ($accounts->rowCount() + 1);?>')"/></div>
				
				<div class="inline-block">
					<input type="text" name="<?php echo $n . '_budget_code' . $a;?>" id="<?php echo $n . '_budget_code' . $a;?>" class="budgetCodes <?php echo 'budgetRow'.  $n . '_' . $a;?>" value="<?php echo $bank["budget"];?>" disabled="disabled"/>
					<select name="<?php echo $n . '_budget_bank' . $a;?>" class="<?php echo 'budgetRow'.  $n . '_' . $a;?>" disabled="disabled">
					<option value="0">SELECT</option>
						<?php foreach($GLOBALS["PDO"]->query("SELECT * FROM bank_units ORDER by name ASC") as $bank_unit){ ?>
							<option value="<?php echo $bank_unit["id"];?>" <?php if($bank_unit["id"] == $bank["bank_unit"]){echo 'selected';}?>><?php echo ucfirst($bank_unit["name"]);?></option>
						<?php }?>
					</select>
					<br/>
					<input type="text" name="<?php echo $n . '_budget_iban' . $a;?>" class="iban napIBAN <?php echo 'budgetRow'.  $n . '_' . $a;?>" value="<?php echo $bank["IBAN"];?>" disabled="disabled"/>
					<textarea type="text" name="<?php echo $n . '_budget_text' . $a;?>" class="budgetTexts <?php echo 'budgetRow'.  $n . '_' . $a;?>" maxlength="70" disabled="disabled"><?php echo $bank["description"] . static::caserNumbersDescription($distribution, $creditor_name);?></textarea>
				</div>
			</div>
		<?php
		$n++;
		}
		?>
		</td>
		<td>
		<?php for($b = 1; $b < $n; $b++){ ?>
			<div class="budgetAmountWrapper"><input type="text" name="<?php echo $b . '_budget_amount' . $a;?>" id="<?php echo $b . '_budget_amount' . $a;?>" class="budgetAmount <?php echo 'budgetRow'.  $b . '_' . $a;?>" value="<?php echo $sum;?>" onchange="csi.calculateSums('<?php echo $a;?>', '<?php echo $n;?>')" disabled/></div>
		<?php } ?>
		</td>
		</td>
		<?php
	}
	
	public static function sum_format($sum){
		return number_format($sum, 2, ".", ",");
	}
}

$Pay = new Pay;	
?>
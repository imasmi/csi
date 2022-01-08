<?php
namespace plugin\Reference;

class Bnb{	
	public function pCode($person){
		return ($person["type"] == "person") ? "100" : "200";
	}
	
	public function bnb_id($code){
		return ($code == 100) ? "ЕГН" : "ЕИК/БУЛСТАТ";
	}
	
	public function checkbox($person, $case_id, $checked=false){
		return '<input id="bnb_'. $person["EGN_EIK"] . '" class="bnbCheckbox" type="checkbox" name="bnb_'. $person["EGN_EIK"] . '_' . $case_id . '" value="' .  $this->pcode($person) . '" ' . (($checked !== false) ? 'checked' : '') . '/>';
	}
	
	public function refLink(){
		return \system\Core::url() . 'Reference/query/bnb';
	}
	
	public function fields($array){
		$fields = array();
		foreach($array->field as $value){
			$fields[(string)$value["name"]] = (string)$value["value"];
		}
		return $fields;
	}
	
	public function bnb_field($array, $field){
		foreach($array->field as $value){
			if($value["name"] == $field){
				return (string)$value["value"];
			}
		}
	}
	
	public function _($xml){
		$bnb = array();
		foreach($xml->person as $person){
			$array = array("identity_type" => (string)$person["identity_type"], "processed_status" => (string)$person["processed_status"], "processed_time" => (string)$person["processed_time"]);
	
			if($person->accounts){
			foreach($person->accounts->account as $account){
				$barr = $this->fields($account);
		
				if($account->attachments){
				foreach($account->attachments->attachment as $attachment){ $barr["attachments"][] = $this->fields($attachment);}
				}
				$array["bank"][(string)$this->bnb_field($account, "unit_code")][] = $barr;
			}
		}
	
		if($person->safes){
		foreach($person->safes->safe as $safe){	$array["safes"][(string)$this->bnb_field($safe, "unit_code")][] = $this->fields($safe);}
		}
	
		$bnb[(string)$person["identity"]][] = $array;
	
		}
		return $bnb;
	}
	
	public function accounts($accounts){
		if($accounts){?>
		<h4>БАНКОВИ СМЕТКИ</h4>
		<?php foreach($accounts as $bank){?>
			<table border="1" style="border-collapse: collapse; margin-top: 30px; font-size: 12px;">
				<tr><th colspan="10"><?php echo $bank[0]["unit_name"];?></th></tr>	
				<tr>
					<th>Име/ Наименование на лицето</th>
					<th>Номер на сметка</th>
					<th>Вид сметка / групова характеристика</th>
					<th>Валута</th>
					<th>Дата откриване</th>
					<th>Дата закриване</th>
					<th>Статут</th>
					<th>Начална дата</th>
					<th>Крайна дата</th>
					<th>Инф. е актуална към дата</th>
				</tr>
				
			<?php foreach($bank as $account){?>
				<tr>
					<td><?php echo $account["name"];?></td>
					<td><?php echo $account["account_num"];?></td>
					<td><?php echo $account["type_name"];?></br><?php echo $account["group_name"];?></td>
					<td><?php echo $account["currency_code"];?></td>
					<td><?php echo $account["open_date"];?></td>
					<td><?php echo $account["close_date"];?></td>
					<td><?php echo $account["role_name"];?></td>
					<td><?php echo $account["entity_valid_from"];?></td>
					<td><?php echo $account["entity_valid_to"];?></td>
					<td><?php echo $account["bank_upd_date"];?></td>
				</tr>
			
				<?php if(isset($account["attachments"])){
				?>
				<tr>
					<th colspan="7">Идентификационен номер на запор на сметка</th>
					<th>Дата на налагане</th>
					<th>Дата на вдигане</th>
					<th>Инф. е актуална към дата</th>
				</tr>
				
				<?php foreach($account["attachments"] as $attachment){?>
				<tr>
					<td colspan="7"><?php echo $attachment["attachment_num"];?></td>
					<td><?php echo $attachment["attachment_valid_from"];?></td>
					<td><?php echo $attachment["attachment_valid_to"];?></td>
					<td><?php echo $attachment["attachment_upd_date"];?></td>
				</tr>
				<?php } ?>
				<?php } ?>
			<?php }?>
			</table>
		<?php } ?>
		<?php } else {?>		
		<h4>По зададените критерии липсват данни за банкова сметка.</h4>
		<?php
		}
	}
	
	public function safes($safes){
		if($safes){?>
		<h4>ДОГОВОРИ ЗА НАЕМ НА БАНКОВИ СЕЙФОВЕ</h4>
		<?php foreach($safes as $bsafe){?>
			<table border="1" style="border-collapse: collapse; margin-top: 30px; font-size: 12px;">	
				<tr><th colspan="10"><?php echo $bsafe[0]["unit_name"];?></th></tr>
				<tr>
					<th>Име/ Наименование на лицето</th>
					<th>Номер и дата на договора за наем</th>
					<th>Брой сейфове</th>
					<th>Начало на ползване</th>
					<th>Край на ползване</th>
					<th>Статут</th>
					<th>Начална дата</th>
					<th>Крайна дата</th>
					<th>Инф. е актуална към дата</th>
				</tr>
			
			<?php foreach($bsafe as $safe){?>
				<tr>
					<td><?php echo $safe["name"];?></td>
					<td>№<?php echo $safe["contract_num"];?>/<?php echo $safe["contract_date"];?></td>
					<td><?php echo $safe["safe_count"];?></td>
					<td><?php echo $safe["safe_valid_from"];?></td>
					<td><?php echo $safe["safe_valid_to"];?></td>
					<td><?php echo $safe["role_name"];?></td>
					<td><?php echo $safe["entity_valid_from"];?></td>
					<td><?php echo $safe["entity_valid_to"];?></td>
					<td><?php echo $safe["bank_upd_date"];?></td>
				</tr>
			<?php }?>
			</table>
		<?php }?>
		<?php } else {?>
			<h4>По зададените критерии липсват данни за банков сейф.</h4>
		<?php }
	}
	
	public function caser($id){
		$person = \system\Database::select($id, "EGN_EIK", "person", "id");
		foreach($this->PDO->query("SELECT c.number FROM caser_title t, caser c WHERE c.id=t.case_id AND t.debtor LIKE '%\"" . $person["id"] . "\"%'") as $case){
			echo '<div>' . $case["number"] . '</div>';
		}
	}
}
?>

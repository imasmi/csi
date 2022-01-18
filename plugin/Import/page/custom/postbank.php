<?php
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Bordero/Postbank_xml.php');
$Postbank_xml = new \plugin\Money\Bordero\Postbank_xml($xml);
?>

<div class="admin">
	<h2 class="text-center">Импортиране на плащания</h2>
	<form action="<?php echo \system\Core::query_path(0, -1);?>/postbank-payments" method="post">
		<table class="csi" border="1px">
			<tr>
				<th></th>
				<th></th>
				<th>Дело</th>
				<th>Описание</th>
				<th>Сума в лева</th>
				<th>Дата на превод</th>
				<th>Наредител</th>
				<th>Получател</th>
				<th>Банкова сметка</th>
				<th>Дата на изпълнение</th>
				<th>Валута</th>
				<th>Документ</th>
			</tr>
			<?php
			$bank = explode('<td', $file);
			$csi_banks = array();
			foreach($PDO->query("SELECT id, description FROM bank WHERE person_id=1") as $csi_bank){
				$csi_banks[$csi_bank["id"]] = array(
					"id" => $csi_bank["id"],
					"description" => $csi_bank["description"]
				);
			}
			$cnt = 0;
			$amm = 0;
			$array = array();
			foreach($Postbank_xml->items as $pay){
				$Item = new \plugin\Money\Bordero\Item($pay, ["type" => "xml"]);
				$sender_bank = $PDO->query("SELECT id FROM bank WHERE IBAN='" . $Item->sender["IBAN"] . "'")->fetch()["id"];
				$check = $PDO->query("SELECT id FROM payment WHERE amount='" . $Item->amount . "' AND `datetime`='" . date("Y-m-d H:i:s", strtotime($Item->datetime)) . "' AND `number`='" . $Item->number . "'");
				if ($sender_bank == 175 || $check->rowCount() > 0) {
					continue;
				}
				++$cnt;
			?>
				<tr id="payrow_<?php echo $cnt;?>">
					<td>
						<?php echo $cnt;?>
						<input type="hidden" name="type_<?php echo $cnt;?>" value='<?php echo $Item->type;?>'/>
					</td>
					<td><button type="button" class="button" onclick="S.remove('#payrow_<?php echo $cnt;?>')">-</button></td>
					<td><?php echo $Caser->select("case_id_" . $cnt, array("search" => $Item->description));?></td>
					<td><textarea name="description_<?php echo $cnt;?>"><?php echo $Item->description;?></textarea></td>
					<td><input type="number" name="amount_<?php echo $cnt;?>" value="<?php echo $Item->amount;?>" step="0.01"/></td>
					<td><input type="text" name="datetime_<?php echo $cnt;?>" value="<?php echo $Item->datetime;?>"/></td>
					<td>
						<?php echo $Item->sender["name"];?>
						<input type="hidden" name="sender_<?php echo $cnt;?>" value='<?php echo json_encode($Item->sender, JSON_UNESCAPED_UNICODE);?>'/>
					</td>
					<td>
						<?php echo $Item->receiver["name"];?>
						<input type="hidden" name="receiver_<?php echo $cnt;?>" value='<?php echo json_encode($Item->receiver, JSON_UNESCAPED_UNICODE);?>'/>
					</td>
					<td>
						<?php $receiver_bank = $PDO->query("SELECT id FROM bank WHERE IBAN='" . $Item->receiver["IBAN"] . "'")->fetch()["id"]; ?>
						<select name="bank_<?php echo $cnt;?>">
							<option value="0">SELECT</option>
							<?php foreach($csi_banks as $csi_bank){?>
								<option value="<?php echo $csi_bank["id"];?>" <?php if($csi_bank["id"] == $receiver_bank){ echo 'selected';}?>><?php echo $csi_bank["description"];?></option>
							<?php } ?>
						</select>
					<td><input type="text" name="execution_time_<?php echo $cnt;?>" value="<?php echo $Item->execution_time;?>"/></td>
					<td><input type="text" name="currency_<?php echo $cnt;?>" value="<?php echo $Item->currency;?>"/></td>
					<td><input type="text" name="number_<?php echo $cnt;?>" value="<?php echo $Item->number;?>"/></td>
				</tr>
			<?php
			$amm+= $Item->amount;
			}
			?>
			<tr>
				<td></td>
				<td><?php echo $amm;?></td>
				<td colspan="100%"></td>
			</tr>
		</table>
	<input type="hidden" name="cnt" value="<?php echo $cnt;?>"/>
	<select name="reason" required>
		<option value="">ИЗБЕРЕТЕ</option>
		<option value="Погaсяване на дълг">Погaсяване на дълг</option>
		<option value="Предплащане на такси">Предплащане на такси</option>
	</select>
	<?php 
	$banks = array();
	foreach($PDO->query("SELECT id, IBAN FROM bank WHERE person_id = '1' ORDER by id ASC") as $unit){
		$units[$unit["id"]] = $unit["IBAN"];
	}
	\system\Form::select("bank", $units, ["required" => true]);?>
	<button class="button">Save</button>
	</form>
</div>

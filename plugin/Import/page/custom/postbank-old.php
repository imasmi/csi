<div class="admin">
	<h2 class="text-center">Проверка на банка</h2>
	<form action="<?php echo \system\Core::query_path(0, -1);?>/postbank-payments" method="post">
		<table class="csi" border="1px">
			<tr>
				<th></th>
				<th></th>
				<th>Дело</th>
				<th>Документ</th>
				<th>Сума в лева</th>
				<th>Дата</th>
				<th>Наредител</th>
				<th>Получател</th>
				<th>Банкова сметка</th>
				<th>Описание</th>
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
			for($a = 16; $a < (count($bank)); $a+=12){

				$document = $Import->clearEmpty($Import->clearBank($bank[$a]));
				$amount = $Import->clearEmpty($Import->clearBank($bank[$a + 3]));
				$state = $Import->clearEmpty($Import->clearBank($bank[$a + 4]));
				$type = $Import->clearEmpty($Import->clearBank($bank[$a + 5]));
				$date = $Import->clearEmpty($Import->clearBank($bank[$a + 8]));
				$date_split = explode(".", mb_substr($date, 0, 10));
				$date = $date_split[2] . "-" . $date_split[1] . "-" . $date_split[0] . " " . mb_substr($date, -8);
				$debtor = $Import->clearEmpty($Import->clearBank($bank[$a + 9]));
				$creditor = $Import->clearEmpty($Import->clearBank($bank[$a + 10]));
				$bank_account = explode(" ", $creditor);
				$bank_id = $PDO->query("SELECT id FROM bank WHERE IBAN='" . $bank_account[0] . "'")->fetch()["id"];
				$description = $Import->clearEmpty($Import->clearBank($bank[$a + 11]));

				$check = $PDO->query("SELECT * FROM payment WHERE amount='" . $amount . "' AND transaction_date='" . $date . "' AND bank='" . $bank_id . "'");
			if(((isset($_POST["custom"]) && $_POST["custom"] == "postbank") || strpos($debtor, "ТАРЛЬОВСКИ") === false) && $check->rowCount() == 0){
				++$cnt;
			?>
				<tr id="payrow_<?php echo $cnt;?>">
					<td><?php echo $cnt;?></td>
					<td><button type="button" class="button" onclick="S.remove('#payrow_<?php echo $cnt;?>')">-</button></td>
					<td><?php echo $Caser->select("case_id_" . $cnt, array("search" => $description));?></td>
					<td><input type="text" name="bordero_<?php echo $cnt;?>" value="<?php echo $document;?>"/></td>
					<td><input type="number" name="amount_<?php echo $cnt;?>" value="<?php echo $amount;?>" step="0.01"/></td>
					<td><input type="text" name="date_<?php echo $cnt;?>" value="<?php echo $date;?>"/></td>
					<td><input type="text" name="debtor_<?php echo $cnt;?>" value="<?php echo $debtor;?>"/></td>
					<td><input type="text" name="creditor_<?php echo $cnt;?>" value="<?php echo $creditor;?>"/></td>
					<td>
						<select name="bank_<?php echo $cnt;?>">
							<option value="0">SELECT</option>
							<?php foreach($csi_banks as $csi_bank){?>
								<option value="<?php echo $csi_bank["id"];?>" <?php if($csi_bank["id"] == $bank_id){ echo 'selected';}?>><?php echo $csi_bank["description"];?></option>
							<?php } ?>
						</select>
					<td><textarea name="description_<?php echo $cnt;?>"><?php echo $description;?></textarea></td>
				</tr>
			<?php
			$amm+= $amount;
			}
			}
			?>
			<tr>
				<td></td>
				<td><?php echo $amm;?></td>
				<td colspan="100%"></td>
			</tr>
		</table>
	<input type="hidden" name="cnt" value="<?php echo $cnt;?>"/>
	<button class="button">Save</button>
	</form>
</div>

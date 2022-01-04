<table class="admin" border="1px">
	<tr><th colspan="100%">Проверка на банка</th></tr>
	<tr>
		<th></th>
		<th>Документ</th>
		<th>Сума в лева</th>
		<th>Дата</th>
		<th>Наредител</th>
		<th>Описание</th>
		<th>фактура</th>
		<th>Сума фактура</th>
		<th>Сметки</th>
		<th>Сума сметки</th>
		<th>Възстановено платежно</th>
		<th>Сума възстановено</th>
		<th>Бележка</th>
		<th>Обща сума</th>
	</tr>
	<?php
	$fast_match = [];
	$cnt = 0;
	$amm = 0;
	$start = isset($_GET["start"]) ? $_GET["start"] : date("Y-m-01");
	$end = isset($_GET["end"]) ? $_GET["end"] : date("Y-m-31");
	$total = 0;
	$payments = array();
	$invoice_id = 0;
	foreach($PDO->query("SELECT id FROM payment WHERE date >= '" . $start . "' AND date <= '" . $end . "' AND bank='8' ORDER by date ASC") as $postbank){

		$invoices = $PDO->query("SELECT id, type, bill, invoice, sum, date FROM invoice WHERE payment LIKE '%\"" . $postbank["id"] . "\"%'");
		if($invoices->rowCount() > 0){
			foreach($invoices as $invoice){
				$payments[$invoice["id"]][$postbank["id"]] = $invoice;
				$invoice_id += 1000;
			}
		} else {
			$payments[$invoice_id][$postbank["id"]] = null;
		}
	}
	?>

		<?php
		$pay_prev = 0;
		$bill_prev = 0;
		$exclude = array();
		foreach($payments as $bill_id => $bill){
			foreach($bill as $postbank_id => $invoice){
				if(!in_array($postbank_id, $exclude)){
					$exclude[] = $postbank_id;
					$pay_prev = $postbank_id;
					$total_sum = 0;
					$postbank = $PDO->query("SELECT * FROM payment WHERE id='" . $postbank_id . "'")->fetch();
			?>
				<tr>
					<td>
						<?php echo ++$cnt;?>
						<input type="hidden" name="invoice_<?php echo $cnt;?>" value="<?php echo $postbank["id"];?>"/>
					</td>
					<td><?php echo $postbank["bordero"];?></td>
					<td><?php echo $postbank["amount"];?></td>
					<td><?php echo $postbank["transaction_date"];?></td>
					<td><?php echo $postbank["debtor"];?></td>
					<td><?php echo $postbank["description"];?></td>

					<?php
					if($invoice == null || $bill_id != $bill_prev){
						$bill_prev = $bill_id;
						$rowspan = $invoice == null ? 1 : count($bill);
					?>
					<td class="color-1-bg" rowspan="<?php echo $rowspan;?>">
						<?php
							foreach($payments as $sub_bill){
								foreach($sub_bill as $sub_postbank_id => $sub_invoice){
									if($bill_id != 0 && $sub_postbank_id == $postbank_id){
										if($sub_invoice["type"] == "invoice"){echo $sub_invoice["invoice"] . "/" . \web\php\dates::_($sub_invoice["date"]) . "<br>";}
									}
								}
							}
						?>
					</td>


					<td class="color-1-bg" rowspan="<?php echo $rowspan;?>">
						<?php
							foreach($payments as $sub_bill){
								foreach($sub_bill as $sub_postbank_id => $sub_invoice){
									if($bill_id != 0 && $sub_postbank_id == $postbank_id){
										if($sub_invoice["type"] == "invoice"){
											echo $sub_invoice["sum"] . "<br>";
											$total_sum += $sub_invoice["sum"];
										}
									}
								}
							}
						?>
					</td>
					<td class="color-3-bg" rowspan="<?php echo $rowspan;?>">
						<?php
							foreach($payments as $sub_bill){
								foreach($sub_bill as $sub_postbank_id => $sub_invoice){
									if($bill_id != 0 && $sub_postbank_id == $postbank_id){
										if($sub_invoice["type"] == "bill"){echo $sub_invoice["bill"] . "/" . \web\php\dates::_($sub_invoice["date"]) . "<br>";}
									}
								}
							}

						?>
					</td>
					<td class="color-3-bg" rowspan="<?php echo $rowspan;?>">
						<?php
							foreach($payments as $sub_bill){
								foreach($sub_bill as $sub_postbank_id => $sub_invoice){
									if($bill_id != 0 && $sub_postbank_id == $postbank_id){
										if($sub_invoice["type"] == "bill"){
											echo $sub_invoice["sum"] . "<br>";
											$total_sum += $sub_invoice["sum"];
										}
									}
								}
							}
						?>
					</td>


					<?php
					$refunds = array();
					foreach($PDO->query("SELECT * FROM " . $Setting->table . " WHERE tag='refund' AND fortable='payment' AND page_id='" . $postbank["id"] . "'") as $refund){
						$refunds[$refund["id"]] = $refund;
					}
					?>
					<td rowspan="<?php echo $rowspan;?>">
						<?php
							foreach($refunds as $refund){
								echo $refund["bg"] . '<br>';
							}
						?>
						<?php if(!isset($_GET["print"])){?><a href="<?php echo \system\Core::url();?>Money/payment/refund/index?id=<?php echo $postbank["id"];?>">Възстановявания</a></td><?php } ?>
					<td rowspan="<?php echo $rowspan;?>">
						<?php
							foreach($refunds as $refund){
								echo $refund["value"] . '<br>';
								$total_sum+=$refund["value"];
							}
						?>
					</td>
					<td rowspan="<?php echo $rowspan;?>"><?php echo $postbank["note"];?></td>
					<?php $check_match = (string) $total_sum == (string) $postbank["amount"];?>
					<td class="<?php if(!$check_match){ echo 'color-2-bg';}?>" rowspan="<?php echo $rowspan;?>"><?php echo $total_sum;?></td>
					<?php 
					if(!$check_match){ $fast_match[] = $postbank;}
				} ?>
				</tr>
		<?php
			$amm+= $postbank["amount"];
			$total+=$total_sum;
				}
		}
	}
	?>
	<tr>
		<td colspan="2">Суми:</td>
		<td><?php echo $amm;?></td>
		<td colspan="10"></td>
		<td><?php echo $total;?></td>
	</tr>
</table>
<?php if(!isset($_GET["print"])){?><button class="button" onclick="window.open('<?php echo $_SERVER["REQUEST_URI"];?>&print')">PRINT</button><?php } ?>

<?php if (count($fast_match) > 0) {?>
<form method="post" action="<?php echo \system\Core::url();?>Money/postbank-invoices-fast-match" class="marginY-20">
	<input type="hidden" name="fast_match" value='<?php echo json_encode($fast_match);?>'/>
	<button class="button">Fast match</button>
</form>
<?php } ?>

<?php
	$select = $Query->select($_GET["id"], "id", "invoice", "*", "LIKE");
	$Person = new \plugin\Person\php\Person($select["payer"]);
?>
<div class="admin">
<h2 class="text-center title"><?php echo $select["type"] == "bill" ? "Сметка " . $select["bill"] : "Фактура " . $select["invoice"];?></h2>
<h3 class="text-center">Сума: <?php echo $select["sum"];?> лева</h3>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo $Core->query_path();?>?id=<?php echo $_GET["id"];?>" method="post">
	<table class="table">
        <tr>
            <td>Дело</td>
            <td><?php $Caser->select("case_id", array("id" => $select["case_id"]));?></td>
        </tr>

		<tr>
            <td>Дата</td>
            <td><input type="date" name="date" value="<?php echo $select["date"];?>"/></td>
        </tr>

		<tr>
            <td>Задължено лице</td>
            <td><?php echo $Person->select("payer", array("id" => $select["payer"]));?></td>
        </tr>

		<tr>
            <td>Плащания</td>
            <td>
				<div id="invoice-payments">
				<?php
					$pay_cnt = 0;
					if($select["payment"]){
						foreach(json_decode($select["payment"]) as $pay_id){
							++$pay_cnt;
							$payment = $Query->select($pay_id, "id", "payment");
							?>
								<div id="payment-<?php echo $pay_cnt;?>">
									<input type="hidden" type="number" name="payment_<?php echo $pay_cnt;?>" value="<?php echo $payment["id"];?>"/>
									<button type="button" class="button" onclick="S.remove('#payment-<?php echo $pay_cnt;?>')">-</button>
									<span><?php echo $payment["amount"];?></span>-
									<span><?php echo $payment["date"];?></span>
									<span>Платени от <?php echo $Query->select($payment["person"], "id", "person")["name"];?></span>
									<span> (<?php echo $payment["description"];?>)</span>
								</div>
							<?php
						}
					}
				?>
				</div>
				<input type="hidden" name="payment-cnt" id="payment-cnt" value="<?php echo $pay_cnt;?>"/>
				<button type="button" class="button margin-20" onclick="S.popup('<?php echo $Core->url() . $Plugin->_();?>/query/invoice/add-payment', {invoice: '<?php echo $select["id"];?>', payment_cnt: S('#payment-cnt').value, case_id: S('#case_id').value})">+ Добави</button>
			</td>
        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <button class="button">Save</button>
                <button class="button" type="button" onclick="history.back()">Back</button>
            </td>
        </tr>
    </table>
</form>
</div>

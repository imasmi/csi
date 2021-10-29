<?php $select = $Query->select($_POST["invoice"], "id", "invoice");?>
<div class="popup-content">
	<h2>Добавяне на плащания</h2>
	<div class="title"><?php echo $select["type"] == "bill" ? "Сметка " . $select["bill"] : "Фактура " . $select["invoice"];?></div>
	<div id="find-payments">
		<?php
		$pay_cnt = $_POST["payment_cnt"];
		foreach($PDO->query("SELECT * FROM payment WHERE case_id='" . $_POST["case_id"] . "' ORDER by date DESC") as $payment){
			++$pay_cnt;
			?>
				<div id="payment-<?php echo $pay_cnt;?>" class="find-payment">
					<input type="hidden" type="number" name="payment_<?php echo $pay_cnt;?>" value="<?php echo $payment["id"];?>"/>
					<input type="checkbox" id="add-payment-<?php echo $pay_cnt;?>" class="check-payment"/>
					<button type="button" class="button hide" onclick="S.remove('#payment-<?php echo $pay_cnt;?>')">-</button>
					<span><?php echo $payment["amount"];?> лева</span> -
					<span><?php echo \web\php\dates::_($payment["date"]);?></span>
					<span> (<?php echo $payment["description"];?>)</span>
				</div>
			<?php
		}
		?>
	</div>

	<h3 class="text-center">Намиране на допълнителни плащания</h3>
	<div class="selector">
		<input type="number" step="0.01" autocomplete="off" id="find-data" onkeyup="S.post('<?php echo $Core->url() . $Plugin->_();?>/query/invoice/find-payment', {data: this.value, payment_cnt: S('#new-payment-cnt').value}, '#find-list', true)" placeholder="Сума"/>
		<?php echo $Info->_("Намиране на допълнителни плащания, независимо от делото, за което са вкарани. Плащанията се търсят само по сума!");?>
		<div id="find-list" class="select-list"></div>
	</div>

	<input type="hidden" id="new-payment-cnt" value="<?php echo $pay_cnt;?>"/>

	<div class="margin-20">
		<button type="button" class="button" onclick="addPayments()">Добави</button>
		<button type="button" class="button" onclick="S.popupExit()">Откажи</button>
	</div>
</div>

<script>
	function addPayments(){
		S.all(".find-payment", function(el){
			let checkPayment = el.querySelector(".check-payment");
			if(checkPayment){
				if(checkPayment.checked == false){
					S.remove(el);
				} else {
					S.remove(checkPayment);
					el.querySelector("button").classList.remove("hide");
				}
			}
		});
		S("#invoice-payments").innerHTML = S("#invoice-payments").innerHTML + S("#find-payments").innerHTML;
		S("#payment-cnt").value = S("#new-payment-cnt").value;
		S.popupExit();
	}
</script>

<?php
include_once(\system\Core::doc_root() . '/web/php/dates.php');
$pay_cnt = $_POST["payment_cnt"] + 1;
foreach($PDO->query("SELECT * FROM payment WHERE amount='" . $_POST["data"] . "%' ORDER by date DESC") as $payment){
	?>
		<div class="select-item" onclick="findItem(this)">
			<div id="payment-<?php echo $pay_cnt;?>" class="find-payment">
				<input type="hidden" type="number" name="payment_<?php echo $pay_cnt;?>" value="<?php echo $payment["id"];?>"/>
				<input type="checkbox" id="add-payment-<?php echo $pay_cnt;?>" class="check-payment" checked/>
				<button type="button" class="button hide" onclick="S.remove('#payment-<?php echo $pay_cnt;?>')">-</button>
				<span><?php echo $payment["amount"];?> лева</span> -
				<span><?php echo \web\dates::_($payment["date"]);?></span>
				<span>Платени от <?php echo json_decode($payment["sender"], true)["name"];?></span>
				<span> (<?php echo $payment["description"];?>)</span>
			</div>
		</div>
	<?php
}
?>

<script>
	function findItem(elem){
		S("#find-payments").innerHTML = S("#find-payments").innerHTML + elem.innerHTML;
		S("#find-data").value = "";
		S("#find-list").innerHTML = "";
		S("#new-payment-cnt").value = '<?php echo $pay_cnt;?>';
	}
</script>

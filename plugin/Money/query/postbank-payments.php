<?php
//print_r($_POST);
for($a = 1; $a <= $_POST["total_cnt"]; ++$a){
	$invoice = $_POST["invoice_" . $a];
	$case_id = $_POST["selector_" . $a] ? $PDO->query("SELECT id FROM caser WHERE number='" . $_POST["selector_" . $a] . "'")->fetch()["id"] : NULL;
	$invoice_field = NULL;
	$bill_field = NULL;
	$note_field = NULL;
	
	if($_POST["invoicing_" . $a . "_cnt"]){
		for($b = 1; $b <= $_POST["invoicing_" . $a . "_cnt"]; ++$b){
			if($_POST["invoicing_" . $a . "_" . $b]){
				$invoice_type = $PDO->query("SELECT * FROM invoice WHERE id='" . $_POST["invoicing_" . $a . "_" . $b] . "'")->fetch();
				if($invoice_type["type"] == "invoice"){
					$invoice_field = $_POST["invoicing_" . $a . "_" . $b];
				} else {
					$bill_field = $_POST["invoicing_" . $a . "_" . $b];
				}
			}
		}
	}
		
	if($_POST["direct_invoice_" . $a]){
		$direct_invoice = explode(",", $_POST["direct_invoice_" . $a]);
		if(count($direct_invoice) > 1){
			$invoice_array = array();
			foreach($direct_invoice as $direct_invoice){
				$invoice_array[]= $PDO->query("SELECT id FROM invoice WHERE invoice='" . $direct_invoice . "'")->fetch()["id"];
			}
			$invoice_field = !empty($invoice_array) ? implode(",", $invoice_array) : NULL;
		} else {
			$invoice_field = $PDO->query("SELECT id FROM invoice WHERE invoice='" . $_POST["direct_invoice_" . $a] . "'")->fetch()["id"];
		}
	}
	
	if($_POST["direct_bill_" . $a]){
		$direct_bills = explode(",", $_POST["direct_bill_" . $a]);
		if(count($direct_bills) > 1){
			$bills_array = array();
			foreach($direct_bills as $direct_bill){
				$bills_array[]= $PDO->query("SELECT id FROM invoice WHERE bill='" . $direct_bill . "'")->fetch()["id"];
			}
			$bill_field = !empty($bills_array) ? implode(",", $bills_array) : NULL;
		} else {
			$bill_field = $PDO->query("SELECT id FROM invoice WHERE bill='" . $_POST["direct_bill_" . $a] . "'")->fetch()["id"];
		}
	}
	
	if($_POST["note_" . $a]){
		$note_field = $_POST["note_" . $a];
	}
	
	if($invoice_field !== NULL || $bill_field !== NULL || $note_field != NULL){
		$update = array(
			"case_id" => $case_id,
			"invoice" => $invoice_field,
			"bill" => $bill_field,
			"note" => $note_field
		);
		
		\system\Data::update($update, $_POST["invoice_" . $a], "id", "postbank_payment");
	}
}
?>
<script>history.back();</script>
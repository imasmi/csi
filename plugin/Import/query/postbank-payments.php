<?php 
for($a = 1; $a <= $_POST["cnt"]; ++$a){
	if(isset($_POST["amount_" . $a])){
		$person = substr($_POST["debtor_" . $a], 38);
		$person = $PDO->query("SELECT id FROM person WHERE name LIKE '%" . $person . "%'")->fetch();
		$array = array(
			"date" => date("Y-m-d", strtotime($_POST["date_" . $a])),
			"case_id" => $_POST["case_id_" . $a],
			"reason" => "Предплащане на такси",
			"person" => $person["id"],
			"bank" => $_POST["bank_" . $a],
			"amount" => $_POST["amount_" . $a],
			"bordero" => $_POST["bordero_" . $a],
			"transaction_date" => $_POST["date_" . $a],
			"debtor" => $_POST["debtor_" . $a],
			"creditor" => $_POST["creditor_" . $a],
			"description" => $_POST["description_" . $a]
		);
		
		\system\Database::insert($array, "payment");
	}
}
?>
<script>window.open('<?php echo \system\Core::url();?>Money/postbank-payments', '_self');</script>
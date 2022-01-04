<?php
$mass = explode(",", $_GET["id"]);
$payments = array();
for($a = 1; $a <= $_POST["payment-cnt"]; ++$a){
	if($_POST["payment_" . $a]){
		$payments[] = $_POST["payment_" . $a];
		\system\Query::update(array("case_id" => $_POST["case_id"]), $_POST["payment_" . $a], "id", "payment");
	}
}
if(count($mass) > 1){
	$array = array();
	//Имам да го довърша за другите неща, за сега само плащанията са вкарани в масовата редакция, най-добре обща функция за масово редактиране да направя
	$array["payment"] = json_encode($payments);
	foreach($mass as $id){
		\system\Query::update($array, $id, "id", "invoice");
	}
} else {
	$array = array(
		"case_id" => $_POST["case_id"],
		"date" => $_POST["date"],
		"payer" => $_POST["payer"]
	);
	
	$array["payment"] = json_encode($payments);
	\system\Query::update($array, $_GET["id"], "id", "invoice");
}
?>
<script>history.go(-2)</script>
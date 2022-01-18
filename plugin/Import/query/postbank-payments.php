<?php 
for($a = 1; $a <= $_POST["cnt"]; ++$a){
	if(isset($_POST["amount_" . $a])){
		$sender = json_decode($_POST["sender_" . $a], true);
		$person = $PDO->query("SELECT id FROM person WHERE name LIKE '%" . $sender["name"] . "%'")->fetch();

		$array = array(
			"date" => date("Y-m-d", strtotime($_POST["datetime_" . $a])),
			"case_id" => $_POST["case_id_" . $a],
			"type" => $_POST["type_" . $a],
			"user" => $User->id,
			"reason" => $_POST["reason"],
			"person" => $person["id"],
			"bank" => $_POST["bank_" . $a] != 0 ? $_POST["bank_" . $a] : $_POST["bank"],
			"amount" => $_POST["amount_" . $a],
			"allocate" => $_POST["reason"] == "Погaсяване на дълг" ? $_POST["amount_" . $a] : 0,
			"number" => $_POST["number_" . $a],
			"datetime" => date("Y-m-d H:i:s", strtotime($_POST["datetime_" . $a])),
			"execution_time" => date("Y-m-d H:i:s", strtotime($_POST["execution_time_" . $a])),
			"sender" => $_POST["sender_" . $a],
			"receiver" => $_POST["receiver_" . $a],
			"description" => $_POST["description_" . $a],
			"currency" => $_POST["currency_" . $a],
		);

		$check = $PDO->query("SELECT id FROM payment WHERE amount='" . $_POST["amount_" . $a] . "' AND `datetime`='" . date("Y-m-d H:i:s", strtotime($_POST["datetime_" . $a])) . "' AND `number`='" . $_POST["number_" . $a] . "'");
		
		if ( $check->rowCount() > 0) {
			$payment_id = $check->fetch()["id"];
			\system\Database::update( ["data" => $array, "table" => "payment", "where" => "id='" . $payment_id . "'"] );
		} else {
			\system\Database::insert( ["data" => $array, "table" => "payment"] );
		}
	}
}
$open = $_POST["reason"] == "Погaсяване на дълг" ? "payments" : "postbank-payments";
?>
<script>window.open('<?php echo \system\Core::url();?>Money/<?php echo $open;?>', '_self');</script>
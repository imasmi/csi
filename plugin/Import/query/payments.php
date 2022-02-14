<?php
include_once(\system\Core::doc_root() . '/plugin/Import/php/Import.php');
$Import = new \plugin\Import\Import;
$names = $Import->fields()["payment"];
$updates = 0;
$inserts = 0;
	
for($a = 0; $a < $_POST["rows"]; ++$a){
	$array = array();
	foreach($names as $key=>$name){
		if($key == "date"){
			$array[$key] = date("Y-m-d", strtotime($_POST[$key . '-' . $a]));
		} elseif($key == "case_id"){
			$case = $PDO->query("SELECT * FROM caser WHERE number='" . $_POST[$key . '-' . $a] . "'")->fetch();
			$array[$key] = $case ? $case["id"] : "0";
		} elseif($key == "person"){
			$array[$key] = $PDO->query("SELECT id FROM person WHERE name='" . $_POST[$key . '-' . $a] . "'")->fetch()["id"];
		} else {
			$array[$key] = $_POST[$key . '-' . $a];
		}
	}
	
	if(isset($array["amount"]) && isset($array["date"])){
		$checks = $PDO->query("SELECT * FROM payment WHERE amount='" . $array["amount"] . "' AND date='" . $array["date"] . "' AND case_id='" . $array["case_id"] . "'");
		if($checks->rowCount() > 0){
			$check = $checks->fetch();
			\system\Data::update($array, $check["id"], "id", "payment");
			$updates++;
		} else {
			\system\Data::insert($array, "payment");
			$inserts++;
		}
	} else {
	?>
		<h2>Плащането трябва да има сума и дата.</h2>
	<?php
	}
}	

echo 'updates: ' . $updates . '<br/>';
echo 'inserts: ' . $inserts;
$Import->ok();
?>

<?php
include_once(\system\Core::doc_root() . '/plugin/Import/php/Import.php');
$Import = new \plugin\Import\Import;
$names = $Import->fields()["invoice"];
$updates = 0;
$inserts = 0;
	
for($a = 0; $a < $_POST["rows"]; ++$a){
	$array = array();
	foreach($names as $key=>$name){
		if($key == "type"){
			$array[$key] = $_POST[$key . '-' . $a] == "Сметка по чл.79" ? "bill" : "invoice";
		} elseif($key == "date"){
			$array[$key] = date("Y-m-d", strtotime($_POST[$key . '-' . $a]));
		} elseif($key == "case_id"){
			$case = $PDO->query("SELECT * FROM caser WHERE number='" . $_POST[$key . '-' . $a] . "'")->fetch();
			$array[$key] = $case ? $case["id"] : "0";
		} elseif($key == "payer"){
			$array[$key] = $PDO->query("SELECT id FROM person WHERE name='" . $_POST[$key . '-' . $a] . "'")->fetch()["id"];
		} else {
			$array[$key] = $_POST[$key . '-' . $a];
		}
	}
	
	if(isset($array["bill"])){
		$checks = $PDO->query("SELECT * FROM invoice WHERE bill='" . $array["bill"] . "'");
		if($checks->rowCount() > 0){
			$check = $checks->fetch();
			\system\Data::update($array, $check["id"], "id", "invoice");
			$updates++;
		} else {
			\system\Data::insert($array, "invoice");
			$inserts++;
		}
	} else {
	?>
		<h2>Документът трябва да има номер на сметка.</h2>
	<?php
	}
}	

echo 'updates: ' . $updates . '<br/>';
echo 'inserts: ' . $inserts;
$Import->ok();
?>
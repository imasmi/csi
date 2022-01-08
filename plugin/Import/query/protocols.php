<?php
$names = $Import->fields()["protocol"];
$updates = 0;
$inserts = 0;
	
for($a = 0; $a < $_POST["rows"]; ++$a){
	$array = array("type" => "protocol");
	foreach($names as $key=>$name){
		if($key == "date"){
			$array[$key] = date("Y-m-d", strtotime($_POST[$key . '-' . $a]));
		} elseif($key == "case_id"){
			$array[$key] = $PDO->query("SELECT id FROM caser WHERE number='" . $_POST[$key . '-' . $a] . "'")->fetch()["id"];
		} elseif($key == "name"){
			$array[$key] = $Import->doc($_POST[$key . '-' . $a], 'protocol');
		} else {
			$array[$key] = $_POST[$key . '-' . $a];
		}
	}
	
	if(isset($array["number"]) && isset($array["date"])){
		$checks = $PDO->query("SELECT * FROM document WHERE type='protocol' AND number='" . $array["number"] . "' AND date='" . $array["date"] . "'");
		if($checks->rowCount() > 0){
			$check = $checks->fetch();
			\system\Database::update($array, $check["id"], "id", "document");
			$updates++;
		} else {
			\system\Database::insert($array, "document");
			$inserts++;
		}
	} else {
	?>
		<div>Няма номер на протокол или дата на протокол за реда</div>
	<?php
	}
}	

echo 'updates: ' . $updates . '<br/>';
echo 'inserts: ' . $inserts;
$Import->ok();
?>

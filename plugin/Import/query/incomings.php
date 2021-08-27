<?php
$names = $Import->fields()["incoming"];
$updates = 0;
$inserts = 0;
	
for($a = 0; $a < $_POST["rows"]; ++$a){
	$array = array("type" => "incoming");
	foreach($names as $key=>$name){
		if($key == "date"){
			$array[$key] = date("Y-m-d", strtotime($_POST[$key . '-' . $a]));
		} elseif($key == "case_id"){
			$array[$key] = $Query->select($_POST[$key . '-' . $a], "number", "caser")["id"];
		} elseif($key == "sender_receiver"){
			$array[$key] = $Import->person($_POST[$key . '-' . $a]);
		} elseif($key == "name"){
			$array[$key] = $Import->doc($_POST[$key . '-' . $a], 'outgoing');
		} elseif($key == "user"){
			$array[$key] = $Query->select($_POST[$key . '-' . $a], "email", $User->table, "id")["id"];
		}  elseif(!isset($_POST[$key . '-' . $a])){
			unset($array[$key]);
		} else {
			$array[$key] = $_POST[$key . '-' . $a];
		}
	}

	if(isset($array["number"]) && isset($array["date"])){
		$checks = $PDO->query("SELECT * FROM document WHERE type='incoming' AND number='" . $array["number"] . "' AND date='" . $array["date"] . "'");
		if($checks->rowCount() > 0){
			$check = $checks->fetch();
			if($array["name"] == 4 || $array["name"] == 5){$array["note"] = $check["note"];}
			$Query->update($array, $check["id"], "id", "document");
			$updates++;
		} else {
			$Query->insert($array, "document");
			$inserts++;
		}
	} else {
	?>
		<div>Няма номер на изходящ документ или дата на изходящ документ за реда</div>
	<?php
	}
}	

echo 'updates: ' . $updates . '<br/>';
echo 'inserts: ' . $inserts;
$Import->ok();
?>

<?php
include_once(\system\Core::doc_root() . '/plugin/Import/php/Import.php');
$Import = new \plugin\Import\Import;

$numbs = array();
foreach($_POST as $key => $value){  // GET THE NUMBERS OF THE CASES LINES
	if(strpos($key, 'case_number') !== false){
		$case_numb = explode('case_number', $key);
		$numbs[] = $case_numb[1];
	}
}

$updates = 0;
$inserts = 0;

foreach ($numbs as $a){ // SAVE PEOPLE AND CASES DATA
	
// UPDATE creditors data and create array with creditors to add to caser_title
	$creditors = [];
	for($c = 1; $c < $_POST["vzisk_numb" . $a]; $c++){
		if($_POST["creditorid" . $a . $c] != ""){
			$cQuery = "EGN_EIK LIKE :id";
			$cId = $_POST["creditorid" . $a . $c];
		} else {
			$cQuery = "name LIKE :id";
			$cId = $_POST["creditorName" . $a . $c];
		}

		$creditorCheck = $PDO -> prepare("SELECT * FROM person WHERE " . $cQuery);
		$creditorCheck -> execute(array("id" => $cId));
		if($creditorCheck->rowCount() > 0){
			$creditorCheck = $creditorCheck->fetch();
			$creditorsQuery = $PDO -> prepare("UPDATE person SET name=:name, EGN_EIK=:id WHERE id=" . $creditorCheck["id"]);
			$creditorsQuery->execute(array("name" => $_POST["creditorName" . $a . $c], "id" => $_POST["creditorid" . $a . $c]));
			$creditors[] = $creditorCheck["id"];
		} elseif($_POST["creditorName" . $a . $c] != "") {
			$creditorsQuery = $PDO -> prepare("INSERT INTO person(name,type,EGN_EIK) VALUES (:name, :type, :id)");
			$creditorsQuery->execute(array("name" => $_POST["creditorName" . $a . $c], "type" => $_POST["creditortype" . $a . $c], "id" => $_POST["creditorid" . $a . $c]));
			$creditors[] = $PDO -> lastInsertId();
		}
	}
	
// UPDATE debtors data and create array with creditors to add to caser_title
	$debtors = [];
	for($b = 1; $b < $_POST["dlujnici_numb" . $a]; $b++){
		if($_POST["debtorid" . $a . $b] != ""){
			$dQuery = "EGN_EIK LIKE :id";
			$dId = $_POST["debtorid" . $a . $b];
		} else {
			$dQuery = "name LIKE :id";
			$dId = $_POST["debtorName" . $a . $b];
		}
		
		$debtorsCheck = $PDO -> prepare("SELECT * FROM person WHERE " . $dQuery);
		$debtorsCheck -> execute(array("id" => $dId));
		if($debtorsCheck->rowCount() > 0){
			$debtorsCheck = $debtorsCheck->fetch();
			$debtorsQuery = $PDO -> prepare("UPDATE person SET name=:name, EGN_EIK=:id WHERE id=" . $debtorsCheck["id"]);
			$debtorsQuery->execute(array("name" => $_POST["debtorName" . $a . $b], "id" => $_POST["debtorid" . $a . $b]));
			$debtors[] = $debtorsCheck["id"];
		} elseif($_POST["debtorName" . $a . $b] != "") {
			$debtorsQuery = $PDO -> prepare("INSERT INTO person(name,type,EGN_EIK) VALUES (:name, :type, :id)");
			$debtorsQuery->execute(array("name" => $_POST["debtorName" . $a . $b], "type" => $_POST["debtortype" . $a . $b], "id" => $_POST["debtorid" . $a . $b]));
			$debtors[] = $PDO -> lastInsertId();
		}
	}
	

// UPDATE caser
	$charger = ($_POST["charger" . $a] != "") ? $PDO->query("SELECT id FROM " . $User->table . " WHERE email='" . $_POST["charger" . $a] . "'")->fetch()["id"] : 0;
	$caser_array = array(
		"number" => $_POST["case_number" . $a],
		"status" => $_POST["status" . $a],
		"statistic" => $_POST["statistic" . $a],
		"charger" => $charger
	);

	$caser_check = $PDO -> query("SELECT * FROM caser WHERE number = '" .  $_POST["case_number" . $a] . "'");
	if($caser_check->rowCount() > 0){
		$case = $caser_check->fetch();
		\system\Database::update($caser_array, $case["id"], "id", "caser");
		$case_id = $case["id"];
		$updates++;
	} else {
		\system\Database::insert($caser_array, "caser");
		$case_id = $PDO->lastInsertId();
		$inserts++;
	}
	
// UPDATE caser_title
	$title_array = array(
		"case_id" => $case_id,
		"type" => $_POST["titul" . $a],
		"court" => $_POST["court" . $a],
		"number" => $_POST["court_case" . $a],
		"creditor" => json_encode($creditors),
		"debtor" => json_encode($debtors),
	);

	if($_POST["titul" . $a] == "Акт по чл.106/107 от ДОПК"){
		$court_case = explode("/",$_POST["court_case" . $a]);
		$title_array["date"] = date("Y-m-d", strtotime($court_case[1]));
	}

	$title_check = $PDO->query("SELECT * FROM caser_title WHERE case_id='" . $case_id . "' ORDER by id ASC");
	if($title_check->rowCount() > 0){
		$title = $title_check->fetch();
		\system\Database::update($title_array, $title["id"], "id", "caser_title");
	} else {
		\system\Database::insert($title_array, "caser_title");
	}
}
echo 'CASES UPDATED: ' . $updates . '<br/>';
echo 'CASES INSERTED: ' . $inserts;

$Import->ok();
?>

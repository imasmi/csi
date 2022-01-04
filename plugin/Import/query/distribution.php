<?php
$distribution = array();
foreach($_POST as $key => $value){  // GET THE NUMBERS OF THE CASES LINES
	if(strpos($key, 'case_id') !== false){
		$distribution_numb = explode('case_id', $key);
		$distribution[] = $distribution_numb[1];
	}
}

$updates = 0;
$inserts = 0;
$olds = 0;

foreach ($distribution as $a){ // SAVE DISTRIBUTIONS DATA
	$case_id = $PDO->query("SELECT id FROM caser WHERE number='" . ($_POST["case_id" . $a] ? $_POST["case_id" . $a] : 0) . "'")->fetch()["id"];
	$case = ($case_id != "") ? $case_id : 0;
	$user_id = $PDO->query("SELECT id FROM " . $User->table . " WHERE email='" . ($_POST["user" . $a] ? $_POST["user" . $a] : 0) . "'")->fetch()["id"];
	$user = ($user_id != "") ? $user_id : 0;
	$date = date("Y-m-d H:i:s", strtotime($_POST["date" . $a]));
	
	$creditor_sums = array();
	for($c = 0; $c < 10; ++$c){
		if(isset($_POST[$c . "creditor" . $a])){		
			$creditor_id = $PDO->query("SELECT id FROM person WHERE name='" . $_POST[$c . "creditor" . $a] . "'")->fetch()["id"];			
			$creditor_sums[] = array($creditor_id => $_POST[$c . "sum" . $a]);
		}
	}
	$distributed_json = !empty($creditor_sums) ? json_encode($creditor_sums) : NULL;
	
	$distributionCheck = $PDO -> query("SELECT * FROM distribution WHERE date LIKE '" . $date . "' AND case_id='" . $case . "' AND distributed='" . $_POST["distributed" . $a] . "'");
	if($distributionCheck->rowCount() > 0){
		$distrib = $distributionCheck->fetch();
		$updateDistrib = $PDO -> prepare("UPDATE distribution SET creditors=? WHERE id='" . $distrib["id"] . "'");
		$updateDistrib->execute(array($distributed_json));
		$olds++;
	} else {			
		$distributionQuery = $PDO -> prepare("INSERT INTO distribution (case_id, date, user, distributed, creditors, csiTotal, point) VALUES ('" . $case . "', '" . $date. "', '" . $user. "', '" . $_POST["distributed" . $a] . "', ?, '" . $_POST["csiTotal" . $a] . "', '" . $_POST["point" . $a] . "')");
		$distributionQuery->execute(array($distributed_json));
		$inserts++;
	}
}

$PDO -> query("INSERT INTO import_data (import, date) VALUES ('distribution', NOW())");

echo 'Olds: ' . $olds . '<br/>';
echo 'Inserts: ' . $inserts;
$Import->ok();
?>

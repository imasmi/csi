<?php
$case = $select = $PDO->query("SELECT * FROM caser WHERE id='" . $_POST["case_id"] . "'")->fetch();
$debtors = array();
foreach(unserialize($case["debtors"]) as $id){
	$debtors[$id] = $select = $PDO->query("SELECT name FROM person WHERE id='" . $_GET["id"] . "'")->fetch()["name"];
}	
$Form->select("debtor_id", $debtors);
?>
<?php
$case = $Query->select($_POST["case_id"], "id", "caser");
$debtors = array();
foreach(unserialize($case["debtors"]) as $id){
	$debtors[$id] = $Query->select($id, "id", "person", "name")["name"];
}	
$Form->select("debtor_id", $debtors);
?>
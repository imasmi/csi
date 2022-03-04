<?php 
$array = array();
$year = $_GET["year"];
$period = $_GET["period"];

foreach($_POST as $key => $value){
	$fields = explode('_', $key);
	$array[$fields[1]][$fields[2]] = $value;
}

foreach($array as $row => $values){
	$report = $PDO->query("SELECT * FROM report WHERE year='" . $year . "' AND period='" . $period . "' AND type='" . $_GET["type"] . "' AND row='" . $row . "'")->fetch();
	$array = array(
		"value" => json_encode($values)
	);
	
	if($report){
		\system\Data::update($array,$report["id"], "id", "report");
	} else {
		$insert = array(
			"year" => $_GET["year"],
			"period" => $_GET["period"],
			"type" => $_GET["type"],
			"row" => $row,
			"value" => json_encode($values)
		);
		\system\Data::insert($insert, "report");
	}
}
?>
<script>history.back();</script>
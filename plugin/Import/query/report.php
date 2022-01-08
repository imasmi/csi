<?php
$rows = unserialize($_POST["rows"]);
$year = date("Y", strtotime($_POST["date"]));
$period = date("m-d", strtotime($_POST["date"])) < "07-01" ? 1 : 2;
$array = array();

$cnt = 0;
$row_array = array(4,5,7,8,9,11,12,13,15,16,17,18,19,20);
foreach($rows as $row){
	$cnt++;
	if(in_array($cnt, $row_array)){
		$fields = explode(',', $row);
		$a = 0;
		$row_fields = array();
		foreach($fields as $id => $field){
			$a++;
			$field = trim($field,'"');
			if($a > 2){
				$row_fields[$a - 2] = $field;
			}
		}
		if($_POST["type"] == "case"){$row_fields[1] = $row_fields[7] + $row_fields[6] + $row_fields[5] + $row_fields[4] - $row_fields[2];}
		$array[trim($fields[1], '"')] = $row_fields;
	}
}
foreach($array as $row => $values){
	$check = $PDO->query("SELECT * FROM report WHERE year='" . $year . "' AND period='" . $period . "' AND type='" . $_POST["type"] . "' AND row='" . $row . "'");
	if($check->rowCount() > 0){
		$report = $check->fetch();
		$array = array(
			"value" => serialize($values)
		);
		\system\Database::update($array,$report["id"], "id", "report");
	} else {
		$array = array(
			"year" => $year,
			"period" => $period,
			"type" => $_POST["type"],
			"row" => $row,
			"value" => serialize($values)
		);

		\system\Database::insert($array,"report");
	}
}
?>
<script>window.open('<?php echo \system\Core::url() . 'Reference/report/' . $_POST["type"] . '?year=' . $year . '&period=' . $period;?>', '_self');</script>

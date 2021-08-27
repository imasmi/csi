<?php
$docs = "";
$doc_name = array();
foreach($PDO->query("SELECT id, name FROM `doc_types` WHERE (`name` LIKE '%Взискател - молба%' OR `id`='17' OR `id`='35')") as $doc_type){
	$docs .= " name=" . $doc_type["id"] . " OR";
	$doc_name[$doc_type["id"]] = $doc_type["name"];
}
$docs = rtrim($docs, " OR");

$pdate = strtotime(date("Y-m-d") . " - 24 months");
$stopDate = strtotime(date("Y-m-d") . " - 21 months");
$charger = (isset($_GET["user"])) ? " AND c.charger=" . $_GET["user"] : "";
$array = array();

$start = (isset($_GET["start"])) ? $_GET["start"] : date("Y-m-d", strtotime("- 1 day"));
$end = (isset($_GET["end"])) ? $_GET["end"] : date("Y-m-d", strtotime("- 1 day"));

foreach ($PDO->query("SELECT * FROM payment WHERE date >= '" . $start . "' AND date <='" . $end . "' AND `case_id` !=0") as $payment){
	$Caser = new \plugin\Caser\php\Caser($payment["case_id"]);
	$doc = $PDO->query("SELECT * FROM document WHERE case_id=" . $payment["case_id"] . " AND (" . $docs . ") ORDER by date DESC")->fetch();
	$pay = $PDO->query("SELECT date FROM distribution WHERE `case_id`=" . $Caser->id . " ORDER by date DESC")->fetch();

	$color = "lightgreen";
	#ДЕЛА БЕЗ МОЛБИ МЕЖДУ 1.5 и 2 ГОДИНИ
	if($pdate < strtotime($doc["date"]) && $stopDate > strtotime($doc["date"])){
		$color = "orange";
	}

	#ДЕЛА БЕЗ МОЛБИ ОТ ПОВЕЧЕ ОТ 2 ГОДИНИ
	elseif($pdate > strtotime($doc["date"])){
		$color = "darksalmon";
	}

		$lastDocDate = $doc["date"] ? $doc["date"] : "";
		$lastDocName = $doc["date"] ? $doc_name[$doc["name"]] : "";
		$lastPay = $pay["date"] ? $pay["date"] : "";
		$cred = $PDO->query("SELECT id, name FROM person WHERE id='" . $Caser->creditor[0] ."'")->fetch();
		/*
		$c = "";
		foreach($creditors as $creditor){
			$cred = $PDO->query("SELECT name FROM person WHERE id='" . $creditor ."'")->fetch();
			$c .= '<div><?php echo $cred["name"];?></div>
		}
		*/


		$array[$Caser->item["number"]] = array(
						"id" => $Caser->item["id"],
						"amount" => $payment["amount"],
						"number" => $Caser->item["number"],
						"creditor" => $cred["name"],
						"creditor_id" => $cred["id"],
						"docDate" => $lastDocDate,
						"docName" => $lastDocName,
						"pay" => $lastPay,
						"color" => $color
					);
}
krsort($array);

$title = ($start === $end) ? $start : $start . " - " . $end;
?>
<div class="admin">
<h2 class="text-center">Проверка на плащания от <?php echo $title;?></h2>
<table class="listTable" id="payCheckTable" border="1px">

	<tr>
		<th>№</th>
		<th>Сума</th>
		<th>Дело</th>
		<th>Взискател</th>
		<th colspan="2">Последна молба</th>
		<th>Последно разпределение</th>
		<th>!</th>
	</tr>


	<?php
	$cnt = 1;
	foreach($array as $key=>$data){
	$Caser->item_data = $Query->select($Caser->item["id"], "id", "caser");
	?>
		<tr style="background-color: <?php echo $data["color"];?>">
			<td><?php echo $cnt;?></td>
			<td><?php echo $data["amount"];?></td>
			<td><?php echo $data["number"];?></td>
			<td><?php echo $data["creditor"];?></td>
			<td><?php echo $data["docDate"];?></td>
			<td><?php echo $data["docName"];?></td>
			<th <?php if(strtotime($data["pay"]) < strtotime("-2 years")){?>style="background-color: red;"<?php } ?>><?php echo $data["pay"];?></th>
			<td id="notes<?php echo $data["id"];?>"><?php $Note->_(" WHERE (case_id=" . $data["id"] . " OR person_id='" . $data["creditor_id"] . "') AND payment=1 AND hide is NULL", $data["id"], "payment", "#notes" . $data["id"]);?></td>
		</tr>
	<?php
		$cnt++;
	}
	?>
</table>
</div>
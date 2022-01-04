<?php
	$end_date = $_GET["period"] == 2 ? $_GET["year"] . "-12-31" : $_GET["year"] . "-06-30";
	$document = array(
		"325" => "Продажба движими вещи",
		"326" => "Продажба на недвижими имоти",
		"327" => "Въводи",
		"328" => "Предаване на движими вещи"
	);
?>

<?php
foreach($document as $key => $value){
	$array = array();

	foreach($PDO->query("SELECT * FROM document WHERE name='" . $key . "' AND date >= '" . $_GET["year"] . "-01-01' AND date <='" . $end_date . "'") as $document){
		if($document["case_id"] != 0){
			$case = $PDO->query("SELECT * FROM caser WHERE id='" . $document["case_id"] . "'")->fetch();
			$array[$case["statistic"]][] = array("number" => $case["number"], "protocol" => $document["number"], "date" => $document["date"], "charger" => $case["charger"]);
		}
	}
?>
<div>
	<h2><?php echo $value;?></h2>
	<div>
		<?php
			foreach($array as $statistic => $case){
				?>
					<h3><?php echo $statistic;?>: <?php echo count($case);?> броя</h3>
				<?php
			}
		?>
	</div>
</div>
<?php } ?>



<?php
	$array = array();
	$complaint_select = "";
	foreach($PDO->Query("SELECT * FROM doc_types WHERE name LIKE '%ЖАЛБА%'") as $complaint){
		$complaint_select .= "name='" . $complaint["id"] . "' OR ";
	}
	$complaint_select = substr($complaint_select, 0, -3);
	foreach($PDO->query("SELECT * FROM document WHERE (" . $complaint_select . ") AND type='incoming' AND date >= '" . $_GET["year"] . "-01-01' AND date <='" . $end_date . "'") as $document){
		if($document["case_id"] != 0){
			$case = $PDO->query("SELECT * FROM caser WHERE id='" . $document["case_id"] . "'")->fetch();;
			$array[$case["statistic"]][] = array("number" => $case["number"], "document-number" => $document["number"], "document-date" => $document["date"], "charger" => $case["charger"]);
		}
	}
?>

<div>
	<h2>Жалби</h2>
	<div>
		<?php
			foreach($array as $statistic => $case){
				?>
					<h3><?php echo $statistic;?>: <?php echo count($case);?> броя</h3>
				<?php
				foreach($case as $key => $value){
				?>
					<div><?php echo $value["number"];?> - <?php echo $PDO->query("SELECT email FROM " . $User->table . " WHERE id='" . $value["charger"] . "'")->fetch()["email"];?> (Документ <?php echo $value["document-number"];?>/<?php echo date("d.m.Y", strtotime($value["document-date"]));?> год.)</div>
				<?php
				}
			}
		?>
	</div>
</div>

<?php
	$caser = array();
	foreach($rows as $row){
		$case_numb = explode("/", $row);
		if(count($case_numb) > 1){
			$caser[] = rtrim($case_numb[1]) . "8820" . ("400000" + $case_numb[0]);
		} else {
			$caser[] = $row;
		}
	}
	
	sort($caser);
	$year = "";
	foreach($caser as $number){
		$case = $Caser->split_number(trim($number));
		if($year != $case["year"]){ echo '<br/>' . $case["year"] . ' -> ';}
		echo $case["number"] . ',';
		$year = $case["year"];
	}
?>
<?php
	if($_SERVER["REDIRECT_URL"] == "/Caser/open"){
		$case = $Query->select($_GET["id"], "id", "caser");
	?>	
		<title><?php echo $Caser->short_number($case["number"]);?></title>
	<?php	
	}
?>

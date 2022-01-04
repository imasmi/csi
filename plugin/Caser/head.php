<?php
	if($_SERVER["REDIRECT_URL"] == "/Caser/open"){
		$case = $PDO->query("SELECT * FROM caser WHERE id='" . $_GET["id"] . "'")->fetch();
	?>	
		<title><?php echo $Caser->short_number($case["number"]);?></title>
	<?php	
	}
?>

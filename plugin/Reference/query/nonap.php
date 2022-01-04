<?php 
foreach($_POST as $case){
		$noNap = $PDO->query("UPDATE caser SET noNap='1' WHERE id='" . $case . "'");
	}
echo \system\Core::href(\system\Core::url());
?>
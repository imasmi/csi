<?php 
foreach($_POST as $case_id => $value){
	if($value == 1){
		$PDO->query("UPDATE caser SET pusnati_startovi=1 WHERE id='" . $case_id . "'");
	}
}
?>
<script>history.back()</script>
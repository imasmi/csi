<div class="csi view">
<?php 
	$person_query = isset($_GET["id"]) ? "=" . $_GET["id"] : "!=0";
	$person_id = isset($_GET["id"]) ? $_GET["id"] : false;
	$Note->listing(" WHERE person_id" . $person_query . " ORDER by period DESC, id DESC", false, $person_id);
?>
</div>
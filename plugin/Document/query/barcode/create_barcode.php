<?php
if($_POST["barcode"] == ""){
	return false;
} else {
	$document = $PDO->query("SELECT * FROM document WHERE barcode='" . $_POST["barcode"] . "'")->fetch();
	$barcode = new \plugin\Document\php\Barcode;
	$barcode->_($document, $_POST["id"]);
}
?>
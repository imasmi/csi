<?php
if($_POST["barcode"] == ""){
	return false;
} else {
	$document = $Query->select($_POST["barcode"], "barcode", "document");
	$barcode = new \plugin\Document\php\Barcode;
	$barcode->_($document, $_POST["id"]);
}
?>
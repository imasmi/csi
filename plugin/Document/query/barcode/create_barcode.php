<?php
if($_POST["barcode"] == ""){
	return false;
} else {
	include_once(\system\Core::doc_root() . '/plugin/Document/php/Barcode.php');
	$Barcode = new \plugin\Document\Barcode();
	$document = $PDO->query("SELECT * FROM document WHERE barcode='" . $_POST["barcode"] . "'")->fetch();
	$barcode->_($document, $_POST["id"]);
}
?>
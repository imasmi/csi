<?php
$barcode = isset($_POST["barcode"]) ? $_POST["barcode"] : $_GET["barcode"];
$id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];
if($barcode == ""){
	return false;
} else {
	include_once(\system\Core::doc_root() . '/plugin/Document/php/Barcode.php');
	$Barcode = new \plugin\Document\Barcode();
	$document = $PDO->query("SELECT * FROM document WHERE barcode='" . $barcode . "'")->fetch();
	$Barcode->_($document, $id);
}
?>
<?php 
$Barcode = new \plugin\Document\php\Barcode;
$Barcode->create($_GET["text"], $_GET["size"], $_GET["orientation"], $_GET["code_type"]);
?>
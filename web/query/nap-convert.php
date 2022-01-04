<?php
require \system\Core::doc_root() . "/composer/vendor/autoload.php";

$docx = new \IRebega\DocxReplacer\Docx("C:/Users/1/Downloads/NAP_CONVERT/output.docx");
$docx->replaceText("ПРИХОДИТЕ", "Турболентка ПЕПЕЧКОВА");

?>

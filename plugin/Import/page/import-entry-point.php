<?php
#$imFile = isset($_FILES["import"]) ? file_get_contents($_FILES["import"]["tmp_name"]) : "";
include_once(\system\Core::doc_root() . '/plugin/Import/php/Import.php');
$Import = new \plugin\Import\Import;
#BNB
if($_FILES["import"]["type"] == "text/xml"){
	$xml = $Import->xml($_FILES["import"]["tmp_name"]);
	if($_POST["custom"] != "0"){
		require_once("custom/" . $_POST["custom"] . ".php");
	} elseif($xml->ArrayOfAPAccounts->APAccount->BankAccount->BankAccountID == "92ef455cd1174220a46bb262f3b5220f" || $xml->ArrayOfAPAccounts->APAccount->BankAccount->BankAccountID == "eb8485076d534f60ab0d652b1e3086f2"){
		#PRINT PAYMENTS FROM POSTBANK XML
		require_once("print-postbank-payments.php");
	}
}

$file = file_get_contents($_FILES["import"]["tmp_name"]);
$rows = explode("\n", $file);
$fRow = $rows[0];
$Import->fRow = $fRow;
unset($rows[0]);
foreach($rows as $k=>$v){if(empty($v)){unset($rows[$k]);}}

#GO TO CUSTOM REFERENCE CODE
if($_POST["custom"] != "0"){
	$csv = $Import->csv($file);
	require_once("custom/" . $_POST["custom"] . ".php");
} else {
	#Дела
	if(strpos($fRow, "Регистър на заведените дела") !== false){require_once("caser.php");}
	#Входящ регистър
	 else if(strpos($fRow, "Вх. №") !== false){require_once("incomings.php");}
	#Изходящ регистър
	else if(strpos($fRow, "Изх. №") !== false){require_once("outgoings.php");}
	#Фактури
	else if(strpos($fRow, "Сметка №") !== false){require_once("invoice.php");}
	#Плащания
	else if(strpos($fRow, "Платени") !== false){require_once("payment.php");}
	#Разпределения
	else if(strpos($fRow, "Дата на разпределение") !== false){require_once("distribution.php");}
	#Пощенска банка проверка на сметка такси
	else if(isset($rows[13]) && strpos($rows[13], "ЮРОБАНК България АД") !== false){require_once("custom/postbank.php");}
	#Райфайзен банк проверка на сметка такси
	else if(isset($rows[5]) && strpos($rows[5], "DAIS.eBank.Client.WEB.mvc") !== false){ require_once("raiffeisenbank.php");}
	#Отчети
	else if(mb_substr($file,0,7) == '"а","б"'){require_once("report.php");}
	#Протоколи
	else if(strpos($fRow, "Протокол №") !== false){require_once("protocols.php");}
}
?>

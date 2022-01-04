<?php
$date = date("Ymd");
$transferNumb = 0;
$transferSum = 0;

if($_POST["type"] == "directPay"){

	for($a = 1; $a < $_POST["totalPayments"]; $a++){
		if(isset($_POST["payment" . $a]) && $_POST["payment" . $a] == 'on'){
			if($_POST["type" . $a] == "budget"){
				echo 'Pay numb:' . $a . '<br/>';
				echo 'В директни плащания не може да има плащания към бюджета!';
				exit;
			}
			$transferSum += $_POST["amount" . $a];
			$transferNumb++;
		}
	}

	$output = "OMP;DP;" . $date . ";BPBIBGSF;BG81BPBI79301033376203;ЧСИ ГЕОРГИ ЦЕНОВ ТАРЛЬОВСКИ;BGN;" . $transferSum . ";" . $transferNumb . ";;\r\n";
	
	for($a = 1; $a < $_POST["totalPayments"]; $a++){
		if(isset($_POST["payment" . $a]) && $_POST["payment" . $a] == 'on'){
			$bank = $PDO -> query("SELECT * FROM bank WHERE id='" . $_POST["bank" . $a] . "'")->fetch();
			$bank_unit = $PDO -> query("SELECT * FROM bank_units WHERE id='" . $bank["bank_unit"] . "'")->fetch();
			$direct = array(
				"type" => "direct",
				"name" => $_POST["name" . $a],
				"BIC" => $bank_unit["BIC"],
				"IBAN" => $bank["IBAN"],
				"bank_name" => $bank_unit["name"],
				"amount" => $_POST["amount" . $a],
				"description" => $_POST["description" . $a]
			);
			
			
			$output .= "DP;" . $direct["name"] . ";" . $bank_unit["BIC"] . ";" . $direct["IBAN"] . ";" . $bank_unit["name"] . ";" . $direct["amount"] . ";" . $direct["description"] . ";;БИСЕРА;002;;\r\n";
			if(isset($_POST["caseID" . $a])){$PDO -> query("UPDATE caser SET prefBANK = '" . $_POST["bank" . $a] . "' WHERE id='" . $_POST["caseID" . $a] . "'");}
		
			$check_direct = $PDO->query("SELECT id FROM payment_outgoing WHERE `type`='direct' AND name='" . $direct["name"] . "' AND `IBAN`='" . $direct["IBAN"] .  "' AND amount='" . $direct["amount"] . "' AND description='" . $direct["description"] . "'");
			if($check_direct->rowCount() == 0){
				\system\Query::insert($direct, "payment_outgoing");
			}
		}
	}

} elseif($_POST["type"] == "budgetPay"){
	
	for($a = 1; $a < $_POST["totalPayments"]; $a++){
		if(isset($_POST["payment" . $a]) && $_POST["payment" . $a] == 'on'){	
			if($_POST["type" . $a] == "direct"){
				echo 'Pay numb:' . $a . '<br/>';
				echo 'В плащания към бюджета не може да има директни плащания!';
				exit;
			}
			
			for($b = 1; $b < $_POST["rows" . $a]; $b++){
				if(isset($_POST[$b . "_budget_check" . $a]) && $_POST[$b . "_budget_check" . $a] == 'on'){
					$transferSum += $_POST[$b . "_budget_amount" . $a];
					$transferNumb++;
				}
			}
		}
	}

	$output = "OBP;BP;" . $date . ";BPBIBGSF;BG81BPBI79301033376203;;ЧСИ ГЕОРГИ ЦЕНОВ ТАРЛЬОВСКИ;BGN;" . $transferSum . ";" . $transferNumb . ";;\r\n";
	
	for($a = 1; $a < $_POST["totalPayments"]; $a++){
		if(isset($_POST["payment" . $a]) && $_POST["payment" . $a] == 'on'){					
			for($b = 1; $b < $_POST["rows" . $a]; $b++){
				if(isset($_POST[$b . "_budget_check" . $a]) && $_POST[$b . "_budget_check" . $a] == 'on'){						
					$bank = $PDO -> query("SELECT * FROM bank_units WHERE id='" . $_POST[$b . "_budget_bank" . $a] . "'")->fetch();
					$egn = ($_POST["egn_type" . $a] == "person") ? $_POST["egn" . $a] : "";
					$eik = ($_POST["egn_type" . $a] == "firm") ? $_POST["egn" . $a] : "";
					$budgetDoc = isset($_POST["document" . $a]) ? "9" . $_POST["document" . $a] : "9";
					$budgetDate = date("Ymd", strtotime($_POST["doc_date" . $a]));
					
					
					$budget = array(
							"type" => "budget",
							"name" => $_POST["name" . $a],
							"BIC" => $bank["BIC"],
							"IBAN" => $_POST[$b . "_budget_iban" . $a],
							"bank_name" => $bank["name"],
							"amount" => $_POST[$b . "_budget_amount" . $a],
							"description" => (isset($_POST["description" . $a])) ? $_POST["description" . $a] : $_POST[$b . "_budget_text" . $a],
							"budget_code" => $_POST[$b . "_budget_code" . $a],
							"budget_document" => $budgetDoc,
							"budget_date" => $budgetDate,
							"budget_docDate" => $date,
							"budget_eik" => $eik,
							"budget_egn" => $egn,
							"budget_debtor" => $_POST["debtor" . $a]
						);

					$output .= "BP;" . $budget["name"] . ";" . $budget["BIC"] . ";" . $budget["IBAN"] . ";" . $budget["budget_code"] . ";" . $budget["bank_name"] . ";" . $budget["amount"] . ";" . $budget["description"] . ";;" . $budget["budget_document"] . ";" . $budget["budget_date"] . ";" . $budget["budget_docDate"] . ";" . $budget["budget_docDate"] . ";" . $budget["budget_eik"] . ";" . $budget["budget_egn"] . ";;" . $budget["budget_debtor"] . ";БИСЕРА;002;;\r\n";
				
					$check_budget = $PDO->query("SELECT id FROM payment_outgoing WHERE `type`='budget' AND name='" . $budget["name"] . "' AND `IBAN`='" . $budget["IBAN"] .  "' AND budget_code='" . $budget["budget_code"] . "' AND amount='" . $budget["amount"] . "' AND budget_eik='" . $budget["budget_eik"] . "' AND budget_egn='" . $budget["budget_egn"] . "'  AND description='" . $budget["description"] . "'");
					if($check_budget->rowCount() == 0){
						\system\Query::insert($budget, "payment_outgoing");
					}
				}
			}
		}
	}
}

$output = rtrim($output, "\r\n");
echo $_POST["type"];

$file = \system\Core::doc_root() . "/web/file/export/" . $_POST["type"] . ".txt";
$f=fopen($file,"w"); 
# Now UTF-8 - Add byte order mark 
fwrite($f, pack("CCC",0xef,0xbb,0xbf)); 
fwrite($f,$output); 
fclose($f); 

echo '<br/>' . $_POST["start_date"] . '-' . $_POST["end_date"];
echo '<br/><br/><table border="1px">';
foreach($PDO->query("SELECT * FROM caser c, distribution d WHERE d.case_id=c.id AND d.user = '2' AND d.date >= '" . $_POST["start_date"] . " " . $_POST["start_time"]. "' AND d.date <= '" . $_POST["end_date"] . " 23:59:59' ORDER by c.number ASC") as $dis){
	echo '<tr><td>' . $dis["number"] . '</td></tr>';
}
echo '</table>';

echo '<script>location.href="' . \system\Core::this_path(0, -1) . '/payment_export?file=' . $file . '"</script>';
?>

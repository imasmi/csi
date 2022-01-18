<?php
namespace plugin\Import;

class Import{
	public function __construct(){
		global $PDO;
		$this->PDO = $PDO;
		$this->qwdir = \system\Core::url() . "Import/query";
		$this->fRow = ""; // this will be changed in the importTrap file
	}

	public function xml($file){
		return simplexml_load_string(file_get_contents($file));
		return $output;
	}

	public function fields(){
		$array = array();

		$array["caser"] = array(
			"number" => "Изп.дело №",
			"title" => "Изп. титули",
			"statistic" => "Ред статистика",
			"creditor" => "Взискатели/Съделители",
			"debtor" => "Длъжници/Съделители"
		);

		$array["incoming"] = array(
			"date" => "Дата входиране",
			"number" => "Вх. №",
			"case_id" => "Изп.дела №",
			"sender_receiver" => "Подател",
			"name" => "Описание",
			"note" => "Забележки",
			"user" => "Входирано от",
			"barcode" => "Баркод"
		);

		$array["outgoing"] = array(
			"date" => "Дата",
			"number" => "Изх. №",
			"case_id" => "Изп.дела №",
			"sender_receiver" => "Адресат",
			"name" => "Описание",
			"note" => "Забележки",
			"user" => "Изходирано от"
		);

		$array["protocol"] = array(
			"number" => "Протокол №",
			"date" => "Дата",
			"case_id" => "Изп.дела №",
			"name" => "Описание",
			"note" => "Бележки"
		);

		$array["payment"] = array(
			"date" => "Дата",
			"case_id" => "Изп. дела",
			"reason" => "Основание",
			"person" => "Задължено лице",
			"amount" => "Платени",
			"allocate" => "Сума за разпределяне",
			"partitioned" => "Разпределени",
			"unpartitioned" => "Неразпределени"
		);

		$array["invoice"] = array(
			"type" => "Вид",
			"bill" => "Сметка №",
			"invoice" => "Фактура №",
			"case_id" => "Изп.дело №",
			"date" => "Дата издаване",
			"payer" => "Задължено лице",
			"tax_base" => "Сума без ДДС",
			"sum" => "Сума с ДДС",
			"vat" => "ДДС",
			"unpayed" => "Общо неплатени"
		);
		return $array;
	}

	public function numbers($names){
		$numbers = array();
		$cnt = 0;
		foreach($this->row($this->fRow) as $heading){
			if(in_array($heading, $names)){ $numbers[array_search($heading, $names)] = $cnt;}
			++$cnt;
		}
		return $numbers;
	}

	public function button(){
		?>
		<form action="<?php echo \system\Core::url();?>Import/import-entry-point" enctype="multipart/form-data" method="post" id="importForm">
			<input type="file" class="button file-button" name="import" onchange="document.getElementById('importForm').submit()"/>
			<br/>
			<select name="custom" class="space-20">
				<option value="0">SELECT</option>
				<option value="spravki_po_molba">Справки по молба</option>
				<option value="taksi_ot_ASV">Такси от АСВ</option>
				<option value="zasechka_postbank">Засечка пощенска - XML</option>
				<option value="custom">Custom</option>
				<option value="postbank">Пощенска банка</option>
			</select>
		</form>
		<?php
	}

	public function ok(){
		echo '<br/><br/><button class="button" onclick="window.close()" font="6">OK</button>';
	}

	public function csv($file){
		$output = array();
		$rows = explode("\n", $file);
		foreach($rows as $row){
			if(!empty($row)){
				$output[] = str_getcsv($row);
			}
		}
		return $output;
	}

	public function row($rowData){
		$alls = explode('",', $rowData);
		$row = array();
		foreach($alls as $field){
			$row[] = $this->clear($field);
		}
		return $row;
	}

	public function clear($str, $type=false){
		$output = str_replace('"',"",$str);

		if($type=="sum"){$output = str_replace(array(",", " лв."), "", $output);}
		return $output;
	}

	public function removeOE($value){
		return strip_tags(ltrim(ltrim($value, '"even">'), '"odd">'));
	}


	public function clearEmpty($value){
		return trim($value);
	}

	public function clearBank($value){
		$leftClear = explode(">", $value);
		$rightClear = explode("</", $leftClear[1]);
		return $rightClear[0];
	}

	public function dtd($date){
		$date = date("Y-m-d", strtotime($date));
		return $date;
}

	public function doc($name, $type){
		$doc_type = $this->PDO -> prepare("SELECT * FROM doc_types WHERE name=?");
		$doc_type->execute(array($name));
		if($doc_type->rowCount() > 0){
			$docu = $doc_type->fetch();
			\system\Database::update(array("type" => $type), $docu["id"], "id", "doc_types");
			$doc = $docu["id"];
		} else {
			$insertDoc = $this->PDO -> prepare("INSERT INTO doc_types (name,type) VALUES(:name, :type)");
			$insertDoc -> execute(array("name" => $name, "type" => $type));
			$doc = $this->PDO -> lastInsertId();
		}
		return $doc;
	}

	public function person($name, $case_id=0, $pType="debtors"){
		if($name != ""){
			$person = $this->PDO -> prepare("SELECT * FROM person WHERE name LIKE :name");
			$person-> execute(array("name" => '%' . $name . '%'));
			if($person->rowCount() > 0){
				if($case_id != 0){
					$Caser = new \plugin\Caser\php\Caser($case_id);
					foreach($person as $pFinded){
						foreach($Caser->debtor as $pID){
							if($pID == $pFinded["id"]){return $pID;}
						}

						foreach($Caser->creditor as $pID){
							if($pID == $pFinded["id"]){return $pID;}
						}
					}
				}

				$pers = $person->fetch();
				return isset($pers["id"]) ? $pers["id"] : 0;
			} else {
				$insertPerson = $this->PDO -> prepare("INSERT INTO person (name) VALUES(:name)");
				$insertPerson -> execute(array("name" => $name));
				return $this->PDO -> lastInsertId();
			}
		}
		return 0;
	}

	public function lastImport($type){
		$import = $this->PDO -> query("SELECT * FROM import_data WHERE import = '" . $type . "' ORDER by id DESC")->fetch();
		return $import["date"];
	}

	public function clearEvery($val){
		$new = explode(">", $val);
		return $new[1];
	}

	public function clearBNB($bnb){
		$new = explode('value="', $bnb);
		$new = explode('"/>', $new[1]);
		return $new[0];
	}

	public function splitField($field, $delimeter, $cut){
		$new = explode($delimeter, $field);
		$new = explode($cut, $new[1]);
		return $new[0];
	}

	public function listNewCases($import){
		echo '<table class="listTable" border="1px" cellpadding="0" cellspacing="0">';

			echo '<tr><th colspan="10">РЕГИСТЪР НА ЗАВЕДЕНИТЕ ДЕЛА</th></tr>';
			echo '<tr>';
				echo '<th>Изп. дело</th>';
				echo '<th>Длъжник</th>';
				echo '<th>Егн/Еик</th>';
			echo '</tr>';

		$cData = explode(' cursor: pointer;">', $import);

		for($b = 0; $b < count($cData); $b++){
		$rows = explode("\n", $cData[$b]);
		for($a = 0; $a < count($rows); $a++){
			$case_number = $rows[$a]; // CASE NUMBER
			$case_data = explode('<ss:Data ss:Type="String">', $rows[$a + 8]); //CASE DATA
			$titul = explode('<br />', strip_tags($case_data[1], '<br>')); //CASE TITUL
			$dlujnici = explode('<p class="person', $case_data[4]); //CASE DEBTORS

			if(isset($titul) && $titul[0] != ""){
				echo '<tr>';
					echo '<td>' . removeOE(clearEmpty($case_number)) . '</td>';
					$person = ["debtor" => $dlujnici];
					foreach ($person as $name => $values){
						unset($values[0]);
						foreach($values as $value){
							$vzisk = explode('<br/>', strip_tags($value, '<br>')); //CASE CREDITORS
								$persName = explode('">', $vzisk[0]);
								echo '<td>' . removeOE(clearEmpty($persName[1])) . '</td>';
									$id = (strpos($vzisk[1], "ЕГН") !== false) ? ltrim($vzisk[1], "ЕГН/ЕНЧ ") : ltrim($vzisk[1], "ЕИК ");
								echo '<td>' . removeOE(clearEmpty($id)) . '</td>';
						}
					}
				echo '</tr>';
			}
		}
		}
		echo '<table>';
	}
}

$Import = new Import;
?>

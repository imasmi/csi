<?php
$dir = $_POST["dir"] . '\\';

$items = [];
$cases = [];
for($a = 1; $a < $_POST["rows"]; ++$a){
	if(isset($_POST["file_" . $a])){
		$items[$a] = [];
		$folder_name = $_POST["dir"] . "/" . $_POST["file_" . $a]; //Assemble the folder name
		$name_convert = iconv ( "UTF-8", "windows-1251" ,  $folder_name ); //Convert the name to windows encoding format
		$case_number = $PDO->query("SELECT number FROM caser WHERE id='" . $_POST["case_" . $a] . "'")->fetch()["number"]; //Get the case number by id
		$cases[] = $case_number;
		$folder_new = $_POST["dir"] . "/" . $case_number . "_" . $_POST["file_" . $a]; //Assemble the new folder name
		$new_convert = iconv ( "UTF-8", "windows-1251" ,  $folder_new ); //Convert the new windows name to windows format

		if(file_exists($name_convert) || is_dir($name_convert)){
			rename($name_convert, $new_convert);
		}


		foreach(\system\Core::list_dir($new_convert, ["select" => "file"]) as $file){
			$file_name = iconv ( "windows-1251", "UTF-8" ,  $file );
			$pathinfo = pathinfo($file_name);
			$pathinfo["case"] = $case_number;
			$pathinfo["new_dir"] = $folder_new;
			if($pathinfo["extension"] == "rtf" || $pathinfo["extension"] == "doc" || $pathinfo["extension"] == "docx"){
				array_unshift($items[$a], $pathinfo);
			} else {
				$items[$a][] = $pathinfo;
			}
		}
	}
}

$case_count = [];
foreach($items as $item){
	foreach($item as $key => $file){
		if($key == 0){$case_count[$file["case"]][] = 0;}
		$old_file = $file["new_dir"] . "/" . $file["basename"];
		$old_convert = iconv ( "UTF-8", "windows-1251" ,  $old_file );
		$new_file = $file["new_dir"] . "/" . $file["case"] . "-" . count($case_count[$file["case"]]) . "_" . ($key + 1) . "_" . $file["basename"];
		$new_convert = iconv ( "UTF-8", "windows-1251" ,  $new_file );
		if(file_exists($old_convert)){
			rename($old_convert, $new_convert);
		}
	}
}

sort($cases);
foreach($cases as $case){
	echo $case . '<br>';
}
?>

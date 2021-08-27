<?php
$dir = $_POST["dir"] . '\\';
$case_list = array();
for($a = 1; $a < $_POST["rows"]; $a++){
	if(isset($_POST["case_" . $a])){
		$number = $Query->select($_POST["case_" . $a], "id", $Caser->table)["number"];
		$oldName = $dir . $_POST["file_" . $a];
		$oldConv = iconv ( "UTF-8", "windows-1251" ,  $oldName );
		$newName = $dir . $number . "_" . $_POST["file_" . $a];
		$newConv = iconv ( "UTF-8", "windows-1251" ,  $newName );

		if(file_exists($oldConv) || is_dir($oldConv)){
			rename($oldConv, $newConv);
			$case_list[] = $number;
		} else {
			"Couldn't rename: " . $_POST["file_" . $a] . "<br/>";
		}
	}

}
sort($case_list);
foreach($case_list as $list){
	echo $list . '<br/>';
}
?>

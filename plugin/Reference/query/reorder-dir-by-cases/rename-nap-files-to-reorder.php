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
exit;

if($_POST["dir"] != "C:/Users/1/Downloads/NAP_PRINT"){
	echo '<div>FILE PRINTING WITH Print Coductor</div>';

	#REMOVE EVERYTHING FROM PRINT FOLDER FIRST
	array_map('unlink', glob("C:\\Users\\1\\Downloads\\print\\*.*"));

	#MAKE REORDERED COPIES IN C:/Users/1/Downloads/print
	$cnt = 10;
	$folders = iconv ( "UTF-8", "windows-1251" ,  $_POST["dir"] );
	foreach($Core->list_dir($folders, "dir", false) as $folder){
		$folderName = iconv ( "windows-1251", "UTF-8" ,  $folder );
		$folderName = str_replace($_POST["dir"], "", $folderName);
		$subfolder = $_POST["dir"] . '\\' . $folderName;
		$files = iconv ( "UTF-8", "windows-1251" ,  $_POST["dir"] . '\\' . $folderName );
		$a = 1;
		foreach($Core->list_dir($files ) as $file){
			$fileName = iconv ( "windows-1251", "UTF-8" ,  $file );
			$fileName = str_replace($subfolder . "/", "", $fileName);
			$filepath = $subfolder . '\\' . $fileName;
			$ext = pathinfo($filepath, PATHINFO_EXTENSION);
			if($ext == "rtf" || $ext == "doc" || $ext == "docx"){
				$newName = $cnt . '_' .  $fileName;
			} else {
				$newName = ($a+$cnt) . '_' . '.' . $ext;
				$a++;
			}

			$fileConv = iconv ( "UTF-8" , "windows-1251", $filepath );
			$newConv = iconv ( "UTF-8" ,  "windows-1251", 'C:\Users\1\Downloads\print\\' . $newName );

			if (!copy($fileConv, $newConv)) {
				echo "failed to copy $filepath...\n";
			}
			$b = $a;
			echo $filepath . '->' . $newName . '<br/>';
		}
		$cnt+= $b;
	}
}
?>

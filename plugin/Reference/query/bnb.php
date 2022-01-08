<?php
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
include_once(\system\Core::doc_root() . '/web/php/csi.php');
$output = '';
$cnt = 0;
$error = array();
foreach($_POST as $id => $code){
	$cnt++;
	if(strpos($id, "bnb") !== false){
		$bnb_info = explode("_", $id);
		$Caser = new \plugin\Caser\Caser($bnb_info[2]);
		$case = $Caser->item;
		$titul_date = $Caser->title_main["date"];
		if($titul_date == "0000-00-00"){
			$error[] = $case["number"];
		}
		$output .= $code . ";" . $bnb_info[1] . ";027;" . $case["number"] . ";" . date("Ymd", strtotime($titul_date)) . "\r\n";
	}
}

if(!empty($error)){
	?>
		<h1>В справката има дела без дата на изпълнителен лист.</h1>
	<?php
	foreach($error as $case_numb){
	?>
		<div><?php echo $case_numb;?></div>
	<?php
	}
	exit;
}

$file = \system\Core::doc_root() . "/web/file/export/bnbRef.txt";
	
//$output = rtrim($output, "\r\n");
$f=fopen($file,"w"); 
# Now UTF-8 - Add byte order mark 
//fwrite($f, pack("CCC",0xef,0xbb,0xbf)); 
fwrite($f,$output); 
fclose($f);

\web\csi::createTXT($file);
exit;
?>

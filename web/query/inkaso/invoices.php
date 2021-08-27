<?php
$output = "";

foreach($_POST as $key=>$value){
	if($key > $_POST["row"]){ break;}
	$output .= $value . "\n";
}
file_put_contents("output.txt", $output);
?>
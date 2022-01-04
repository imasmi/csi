<?php 
$list = file_get_contents(\system\Core::doc_root() . "/output.txt");
$rows = explode("\n", $list);
$array = array();
foreach($rows as  $row){
	$invoice = explode("/",$row);
	$array[] = $invoice[0];
}

$removes = array();
$cnt = 0;
foreach($PDO->query("SELECT * FROM invoice WHERE type='invoice' AND payer='4936' AND date > '2019-01-01' AND date < '2020-12-31' ORDER by date ASC") as $invoice){
	if(!in_array($invoice["invoice"], $array)){
		++$cnt;
		echo $cnt . '->  ' . $invoice["invoice"] . '/' . date("m.d.Y", strtotime($invoice["date"]));
		echo '<br/>';
	}
}
?>
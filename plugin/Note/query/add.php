<?php
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
$check = array();

#CHECK IF THERE IS NOTE
if($_POST["note"] === ""){ $check["#note"] = "Въведете текст за бележка";}

if(empty($check) == true){

#INSERT IF ALL EVERYTHING IS FINE
$period = (isset($_POST["usePeriod"])) ? $_POST["date"] . " " . $_POST["time"] : "0000-00-00 00:00:00";

$array = array(
			"note" => $_POST["note"],
			"case_id" => $_POST["case_id"],
			"debtor_id" => $_POST["debtor_id"],
			"user_id" => $_POST["user_id"],
			"doc_id" => $_POST["doc_id"],
			"period" => $period,
			"date" => date("Y-m-d H:i:s")
        );
		
foreach(\plugin\Note\Note::places() as $key=>$value){
	$array[$key] = isset($_POST[$key]) ? 1 : 0;
}

$insert = \system\Data::insert($array, "note");
#\system\Data::insert($array, $table="module")

if($insert){
	if(!isset($_POST["where"])){ ?><script>history.go(-1)</script><?php }
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);
}
if(isset($_POST["where"])){\plugin\Note\Note::_($_POST["where"], $_POST["case_id"], $_POST["place"],$_POST["element"]);}

exit;
?>
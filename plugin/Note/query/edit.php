<?php
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
$check = array();

#CHECK IF THERE IS NOTE
if($_POST["note"] === ""){ $check["#note"] = "Въведете текст за бележка";}


#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check) == true){
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
    
    $update = \system\Data::update($array, $_GET["id"], "id", "note");
    #\system\Data::update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")
    
    if($update){
        ?><script>window.close();</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    $Form->validate($check);
}
?>
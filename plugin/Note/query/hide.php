<?php
$select = $Query->select($_GET["id"], "id", "note");

$hide = ($select["hide"] === "0000-00-00 00:00:00") ? date("Y-m-d H:i:s") : "0000-00-00 00:00:00";

$array = array(
			"hide" => $hide
		);


$update = $Query->update($array, $_GET["id"], "id", "note");
#$Query->update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")

if($update){
	if(isset($_GET["type"])){
		echo $hide;
	} else {
		$Core->goBack(-2);
	}
} else {
	 echo $Text->_("Something went wrong");
}
?>
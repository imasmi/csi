<?php
$select = $select = $PDO->query("SELECT * FROM note WHERE id='" . $_GET["id"] . "'")->fetch();

$hide = ($select["hide"] === "0000-00-00 00:00:00") ? date("Y-m-d H:i:s") : "0000-00-00 00:00:00";

$array = array(
			"hide" => $hide
		);


$update = \system\Database::update($array, $_GET["id"], "id", "note");
#\system\Database::update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")

if($update){
	if(isset($_GET["type"])){
		echo $hide;
	} else {
		\system\Core::goBack(-2);
	}
} else {
	 echo $Text->_("Something went wrong");
}
?>
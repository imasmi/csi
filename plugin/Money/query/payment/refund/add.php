<?php
$check = array();
$Object = $Plugin->object();
if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE

$array = array(
	"page_id" => $_GET["id"],
	"fortable" => "payment",
	"plugin" => $Object->plugin,
	"tag" => "refund",
	"value" => number_format($_POST["value"], 2, ".", ""),
	"bg" => $_POST["bg"]
);

$insert = $Query->insert($array, $Setting->table);
#$Query->insert($array, $table="module")

if($insert){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);    
}
exit;
?>
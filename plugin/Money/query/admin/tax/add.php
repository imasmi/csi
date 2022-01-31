<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE
$data = [
    "user_id" => $User->id,
    "fortable" => "tax",
    "tag" => "tax",
    "row" => $_POST["row"],
    "type" => $_POST["type"],
    "value" => number_format($_POST["value"], 2, ".", ""),
];


$insert = \system\Database::insert(["data" => $data, "table" => $Setting->table]);
#\system\Database::insert($array, $table="module")

if($insert){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);    
}
exit;
?>
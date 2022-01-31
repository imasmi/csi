<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE
$data = [
    "caser_id" => $_POST["caser_id"],
    "setting_id" => $_POST["setting_id"],
    "point_number" => $PDO->query("SELECT `row` FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id"] . "'")->fetch()["row"],
    "title_id" => $_POST["title_id"],
    "debtor_id" => $_POST["debtor_id"],
    "count" => $_POST["count"],
    "sum" => $_POST["sum"],
    "note" => $_POST["note"],
    "date" => date("Y-m-d"),
];


$insert = \system\Database::insert(["data" => $data, "table" => "tax"]);

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
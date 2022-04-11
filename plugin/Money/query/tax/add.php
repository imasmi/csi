<?php
$check = array();

if(empty($check)){

if ($_POST["multiselect-counter-debtor_id"]) {
    $debtors = [];
    for ($i = 0; $i < $_POST["multiselect-counter-debtor_id"]; $i++){
        if (isset($_POST["multiselect-debtor_id-" . $i])) {
            $debtors[] = $_POST["multiselect-debtor_id-" . $i];
        }
    }
    $debtors = json_encode(array_unique($debtors));
} else {
    $debtors = null;
}

#INSERT IF ALL EVERYTHING IS FINE
$data = [
    "case_id" => $_POST["case_id"],
    "setting_id" => $_POST["setting_id"],
    "point_number" => $PDO->query("SELECT `row` FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id"] . "'")->fetch()["row"],
    "title_id" => $_POST["title_id"],
    "debtors" => $debtors,
    "count" => $_POST["count"],
    "sum" => $_POST["sum"],
    "distribute" => isset($_POST["distribute"]) && $_POST["distribute"] == "on" ? 1 : 0,
    "final" => isset($_POST["final"]) && $_POST["final"] == "on" ? 1 : 0,
    "note" => $_POST["note"],
    "date" => date("Y-m-d"),
];


$insert = \system\Data::insert(["data" => $data, "table" => "tax"]);

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
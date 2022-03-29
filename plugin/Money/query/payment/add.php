<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE
$debtor = [];
for ($i = 0; $i < $_POST["multiselect-counter-debtor_id"]; $i++){
    if (isset($_POST["multiselect-debtor_id-" . $i])) {
        $debtor[] = $_POST["multiselect-debtor_id-" . $i];
    }
}

if (!empty($debtor)) {
    $debtor = json_encode(array_unique($debtor));
} else {
    ?>
    <h3 class="color-2">Добавете поне един длъжник за плащането</h3>
    <?php
    exit;
}

$data = [
    "date" => $_POST["date"],
    "case_id" => $_POST["case_id"],
    "user" => $User->id,
    "reason" => $_POST["reason"],
    "debtor" => $debtor,
    "bank" => $_POST["bank"],
    "amount" => $_POST["amount"],
    "allocate" => $_POST["allocate"],
    "unpartitioned" => $_POST["allocate"],
    "number" => isset($_POST["number"]) ? $_POST["number"] : null,
    "description" => $_POST["description"],
    "sender" => $_POST["sender"],
    "receiver" => $_POST["receiver"],
];

$insert = \system\Data::insert(["data" => $data, "table" => "payment"]);
#\system\Data::insert($array, $table="module")

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
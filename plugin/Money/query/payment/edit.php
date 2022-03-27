<?php
$check = array();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
$debtors = [];
for ($i = 0; $i < $_POST["multiselect-counter-debtor_id"]; $i++){
    if (isset($_POST["multiselect-debtor_id-" . $i])) {
        $debtors[] = $_POST["multiselect-debtor_id-" . $i];
    }
}

if (!empty($debtors)) {
    $debtors = json_encode(array_unique($debtors));
} else {
    ?>
    <h3 class="color-2">Добавете поне един длъжник за плащането</h3>
    <?php
    exit;
}

$data = [
    "date" => $_POST["date"],
    "case_id" => $_POST["case_id"],
    "reason" => $_POST["reason"],
    "debtors" => $debtors,
    "bank" => $_POST["bank"],
    "amount" => $_POST["amount"],
    "allocate" => $_POST["allocate"],
    "number" => $_POST["number"],
    "description" => $_POST["description"],
    "sender" => $_POST["sender"],
    "receiver" => $_POST["receiver"],
];

    $update = \system\Data::update(["data"=> $data, "table" => "payment", "where" => "id='" . $_GET["id"] . "'"]);
    #\system\Data::update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);
}
?>
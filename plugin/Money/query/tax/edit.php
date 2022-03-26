<?php
$check = array();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
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
        "setting_id" => $_POST["setting_id"],
        "point_number" => $PDO->query("SELECT `row` FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id"] . "'")->fetch()["row"],
        "title_id" => $_POST["title_id"],
        "debtors" => $debtors,
        "count" => $_POST["count"],
        "sum" => $_POST["sum"],
        "note" => $_POST["note"],
        "date" => date("Y-m-d"),
    ];

    $update = \system\Data::update(["data" => $data, "table" => "tax", "where" => "id='" . $_GET["id"] . "'"]);
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
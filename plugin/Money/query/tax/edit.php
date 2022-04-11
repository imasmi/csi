<?php
$check = array();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
    if ($_POST["multiselect-counter-debtor_id"]) {
        $debtor = [];
        for ($i = 0; $i < $_POST["multiselect-counter-debtor_id"]; $i++){
            if (isset($_POST["multiselect-debtor_id-" . $i])) {
                $debtor[] = $_POST["multiselect-debtor_id-" . $i];
            }
        }
        $debtor = json_encode(array_unique($debtor));
    } else {
        $debtor = null;
    }

    #INSERT IF ALL EVERYTHING IS FINE
    $data = [
        "setting_id" => $_POST["setting_id"],
        "point_number" => $PDO->query("SELECT `row` FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id"] . "'")->fetch()["row"],
        "title_id" => $_POST["title_id"],
        "debtor" => $debtor,
        "count" => $_POST["count"],
        "sum" => $_POST["sum"],
        "distribute" => isset($_POST["distribute"]) && $_POST["distribute"] == "on" ? 1 : 0,
        "final" => isset($_POST["final"]) && $_POST["final"] == "on" ? 1 : 0,
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
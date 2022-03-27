<?php
$check = array();

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
        <h3 class="color-2">Добавете поне един длъжник за дълга</h3>
        <?php
        exit;
    }



    $select = $PDO->query("SELECT tag FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id"] . "'")->fetch();
    #INSERT IF ALL EVERYTHING IS FINE
    $data = [
        "caser_id" => $_POST["caser_id"],
        "setting_id" => $_POST["setting_id"],
        "subsetting_id" => $_POST["subsetting_id"],
        "title_id" => $_POST["title_id"],
        "sum" => $_POST["sum"],
        "debtors" => $debtors
    ];

    $insert = \system\Data::insert(["data" => $data, "table" => "debt"]);


    if ($select["tag"] == "interest") {
        $subdata = [
            "caser_id" => $_POST["caser_id"],
            "link_id" => $PDO->lastInsertId(),
            "title_id" => $_POST["title_id"],
            "debtors" => $debtors,
            "sum" => $_POST["sum"],
            "start" => $_POST["start"],
        ];
        \system\Data::insert(["data" => $subdata, "table" => "debt"]);
    }

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
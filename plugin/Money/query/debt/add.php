<?php
$check = array();

if(empty($check)){

  

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
        <h3 class="color-2">Добавете поне един длъжник за дълга</h3>
        <?php
        exit;
    }

    #INSERT IF ALL EVERYTHING IS FINE
    $data = [
        "caser_id" => $_POST["caser_id"],
        "title_id" => $_POST["title_id"],
        "debtor" => $debtor
    ];

    $insert = \system\Data::insert(["data" => $data, "table" => "debt"]);
    $debt_id = $PDO->lastInsertId();

    for ($i = 1; $i <  $_POST["multiselect-counter-row"]; $i++){
        if (isset($_POST["setting_id-" . $i])) {
            $select = $PDO->query("SELECT tag FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id-"  . $i] . "'")->fetch();
            $data = [
                "debt_id" => $debt_id,
                "setting_id" => $_POST["setting_id-" . $i],
                "subsetting_id" => $_POST["subsetting_id-" . $i],
                "sum" => $_POST["sum-" . $i],
                "date" => $_POST["date-" . $i],
            ];
            \system\Data::insert(["data" => $data, "table" => "debt_item"]);

            if ($select["tag"] == "interest") {
                $subdata = [
                    "debt_id" => $debt_id,
                    "link_id" => $PDO->lastInsertId(),
                    "sum" => $_POST["sum-" . $i],
                    "date" => $_POST["date-" . $i],
                ];
                \system\Data::insert(["data" => $subdata, "table" => "debt_item"]);
            }

        }
    }

    
    ?><script>history.go(-1)</script><?php
} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);    
}
exit;
?>
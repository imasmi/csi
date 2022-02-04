<?php
$check = array();

if(empty($check)){
    $select = $PDO->query("SELECT tag FROM " . $Setting->table . " WHERE id='" . $_POST["setting_id"] . "'")->fetch();
    #INSERT IF ALL EVERYTHING IS FINE
    $data = [
        "caser_id" => $_POST["caser_id"],
        "setting_id" => $_POST["setting_id"],
        "subsetting_id" => $_POST["subsetting_id"],
        "title_id" => $_POST["title_id"],
        "sum" => $_POST["sum"]
    ];

    $insert = \system\Database::insert(["data" => $data, "table" => "debt"]);


    if ($select["tag"] == "interest") {
        $subdata = [
            "caser_id" => $_POST["caser_id"],
            "link_id" => $PDO->lastInsertId(),
            "sum" => $_POST["sum"],
            "start" => $_POST["start"]
        ];
        \system\Database::insert(["data" => $subdata, "table" => "debt"]);
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
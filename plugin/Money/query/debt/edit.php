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
        <h3 class="color-2">Добавете поне един длъжник за дълга</h3>
        <?php
        exit;
    }

    $data = [
        "setting_id" => isset($_POST["setting_id"]) ? $_POST["setting_id"] : 0,
        "subsetting_id" => isset($_POST["subsetting_id"]) ? $_POST["subsetting_id"] : 0,
        "title_id" => $_POST["title_id"],
        "debtors" => $debtors,
        "sum" => $_POST["sum"],
        "start" => isset($_POST["start"]) ? $_POST["start"] : null
    ];


    $update = \system\Data::update(["data" => $data, "table" => "debt", "where" => "id='" . $_GET["id"] . "'"]);
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
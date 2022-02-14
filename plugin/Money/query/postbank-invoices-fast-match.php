<?php
foreach($_POST as $key => $post){
    $row = explode("_", $key);
    $cnt = $row[0];
    $data = $row[1];


    if($data != "payment"){
        \system\Data::update(["payment" => json_encode(array($_POST[$cnt . "_payment"]))], $data, "id", "invoice");
        echo $data . '=' . json_encode(array($_POST[$cnt . "_payment"]));
        echo '<br>';
    }
}
?>
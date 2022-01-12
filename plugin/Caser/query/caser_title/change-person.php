<?php
$check = array();
$select = $PDO->query("SELECT * FROM caser_title WHERE id='" . $_GET["id"] . "'")->fetch();


#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){

    
    $person_data = json_decode($select[$_GET["type"]], true);
    $person_data[array_search($_GET["person"],  $person_data)] = $_POST["person"]; 

    $update = \system\Database::update(["data" => [$_GET["type"] => json_encode($person_data)], "table" => "caser_title", "where" => "id='" . $_GET["id"] . "'"]);
    
    if($update){
        ?><script>history.back()</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);
}
?>
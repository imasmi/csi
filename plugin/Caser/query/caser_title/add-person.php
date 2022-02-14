<?php
$check = array();
$select = $PDO->query("SELECT * FROM caser_title WHERE id='" . $_GET["id"] . "'")->fetch();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){

    
    $person_data = json_decode($select[$_GET["type"]], true);
    
    if (is_array( $person_data)) {
        $persons = array_unique(array_merge($person_data, [$_POST["person"]]));
    } else {
        $persons = [$_POST["person"]];
    }
    

    $update = \system\Data::update(["data" => [$_GET["type"] => json_encode($persons)], "table" => "caser_title", "where" => "id='" . $_GET["id"] . "'"]);
    
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
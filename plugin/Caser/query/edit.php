<?php
$check = array();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
    $update = \system\Data::update(["data" => $_POST, "table" => "caser", "where" => "id='" . $_GET["id"] . "'"]);
    #\system\Data::update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")
    
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
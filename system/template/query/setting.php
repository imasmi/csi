<?php
$check = array();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
    $update = \system\Data::update($_POST, $_GET["id"]);
    #\system\Data::update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    \system\Form::validate($check);
}
?>
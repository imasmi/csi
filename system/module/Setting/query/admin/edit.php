<?php
$check = array();
$select = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "'")->fetch();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
    $update = \system\Data::update($_POST, $_GET["id"]);
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    \system\Form::validate($check);
}
?>
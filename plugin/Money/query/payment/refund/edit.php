<?php
$check = array();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    $_POST["value"] = number_format($_POST["value"], 2, ".", "");
    $update = \system\Database::update($_POST, $_GET["id"], "id", $Setting->table);
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    $Form->validate($check);
}
?>
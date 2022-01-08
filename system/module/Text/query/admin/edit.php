<?php
$check = array();

if($_POST["tag"] == ""){ $check["#tag"] = "Lable can't be empty!";}


#UPDATE TEXT DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    $update = \system\Database::update($_POST, $_GET["id"]);
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    \system\Form::validate($check);
}
?>
<?php
$check = array();

#CHECK IF LABEL IS FREE
if($PDO->query("SELECT * FROM " . $Text->table . " WHERE tag='" . $_POST["tag"] . "'")->fetch()->rowCount() > 0){ $check["#username"] = "This tag is already in use";}


if(empty($check)){

#CREATE NEW TEXT IF ALL EVERYTHING IS FINE

$new_text = \system\Data::insert($_POST);

if($new_text){
    ?><script>history.go(-1)</script><?php
} else {
    echo "Something went wrong";
}

} else {
    \system\Form::validate($check);    
}

exit
?>
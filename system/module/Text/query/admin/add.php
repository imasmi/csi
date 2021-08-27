<?php
$check = array();

#CHECK IF LABEL IS FREE
if($Query->select($_POST["tag"], "tag")){ $check["#username"] = "This tag is already in use";}


if(empty($check)){

#CREATE NEW TEXT IF ALL EVERYTHING IS FINE

$new_text = $Query->insert($_POST);

if($new_text){
    ?><script>history.go(-1)</script><?php
} else {
    echo "Something went wrong";
}

} else {
    $Form->validate($check);    
}

exit
?>
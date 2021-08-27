<?php
$check = array();

#CHECK IF USERNAME IS FREE
if($_POST["field"] == ""){ $check["#field"] = "Insert field!";}

if(empty($check)){
#INSERT IF ALL EVERYTHING IS FINE

$insert = $Query->insert($_POST);

if($insert){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);    
}

exit;
?>
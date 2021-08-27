<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE

$insert = $Query->insert($_POST);
#$Query->insert($array, $table="module")

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
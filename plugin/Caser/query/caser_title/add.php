<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE
$insert = \system\Database::insert(["data" => $_POST, "table" => "caser_title"]);
#\system\Database::insert($array, $table="module")

if($insert){
    ?><script>history.back();</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);    
}
exit;
?>
<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE
$_POST["status"] = 55;
$insert = \system\Data::insert(["data" => $_POST, "table" => "caser"]);
#\system\Data::insert($array, $table="module")

if($insert){
    ?><script>window.open('<?php echo \system\Core::url() . "Caser/open?id=" . $PDO->lastInsertId();?>', '_self')</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);    
}
exit;
?>
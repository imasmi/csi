<?php
$check = array();
$Object = $Plugin->object();
$select = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "'")->fetch();

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
    $update = \system\Data::update($_POST, $_GET["id"], "id", $Object->table);
    #\system\Data::update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
	require_once(\system\Core::doc_root() . "/system/php/Form.php");
	$Form = new \system\Form;
    \system\Form::validate($check);
}
?>
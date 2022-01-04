<?php
$check = "";
$select = $PDO->query("SELECT * FROM " . $File->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
if($_POST["tag"] == ""){ $check["#tag"] = "Please insert gallery tag";}

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if($check == ""){
    $update = \system\Query::update($_POST, $_GET["id"]);
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    \system\Form::validate($check);
}
exit;
?>
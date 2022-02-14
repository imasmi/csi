<?php
$check = array();
$profile = $PDO->query("SELECT * FROM " . $User->table . " WHERE id='" . $_GET["id"] . "'")->fetch();

#CHECK IF USERNAME IS FREE IF IT IS CHANGED
if($profile["username"] != $_POST["username"] && $PDO->query("SELECT id FROM " . $User->table . " WHERE username='" . $_POST["username"] . "'")->rowCount() > 0){ $check["#username"] = $Text->_("This username is already in use");}

#CHECK IF EMAIL IS VALID
if(\system\Mail::validate($_POST["email"]) === false){$check["#email"] = $Text->_("Invalid email format");}

#CHECK IF EMAIL IS NOT USED ALREADY IF IT IS CHANGED
if($profile["email"] != $_POST["email"] &&  $PDO->query("SELECT id FROM " . $User->table . " WHERE email='" . $_POST["email"] . "'")->rowCount() > 0){$check["#email"] = $Text->_("There is user registred with this email");}


#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    $update = \system\Data::update($_POST, $_GET["id"]);
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
<?php
$check = array();
$profile = $Query->select($_GET["id"]);

#CHECK IF USERNAME IS FREE IF IT IS CHANGED
if($profile["username"] != $_POST["username"] && $Query->select($_POST["username"], "username")){ $check["#username"] = $Text->_("This username is already in use");}

#CHECK IF EMAIL IS VALID
if($Mail->validate($_POST["email"]) === false){$check["#email"] = $Text->_("Invalid email format");}

#CHECK IF EMAIL IS NOT USED ALREADY IF IT IS CHANGED
if($profile["email"] != $_POST["email"] &&  $Query->select($_POST["email"], "email")){$check["#email"] = $Text->_("There is user registred with this email");}


#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    $update = $Query->update($_POST, $_GET["id"]);
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    $Form->validate($check);
}
exit;
?>
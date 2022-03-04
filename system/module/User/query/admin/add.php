<?php
include_once(\system\Core::doc_root() . "/system/php/Mail.php");
$check = array();

if($_POST["role"] === "0" || empty($_POST["group"])){ $check["#group"] = $Text->_("Please select group");}

#CHECK IF USERNAME IS FREE
if($PDO->query("SELECT id FROM " . $User->table . " WHERE username='" . $_POST["username"] . "'")->rowCount() > 0){ $check["#username"] = $Text->_("This username is already in use");}

#CHECK IF EMAIL IS VALID
if(\system\Mail::validate($_POST["email"]) === false){$check["#email"] = $Text->_("Invalid email format");}

#CHECK IF EMAIL IS NOT USED ALREADY
if($PDO->query("SELECT * FROM " . $User->table . " WHERE email='" . $_POST["email"] . "'")->rowCount() > 0){$check["#email"] = $Text->_("There is user registred with this email");}

#CHECK IF PASSWORD MEET REQUIREMENTS
if($User->pass_requirements($_POST["password"]) != "1"){$check["#password"] = $Text->_("Password requirements are not meet.");}

#CHECK IF PASSWORD MATCHES
if($_POST["password"] != $_POST["repassword"]){$check["#repassword"] = $Text->_("Passwords are not the same");}

if(empty($check)){

#CREATE NEW USERS IF ALL EVERYTHING IS FINE
$activate_code = md5(rand());
$data = array(
            "group" => $_POST["group"],
            "username" => $_POST["username"],
            "email" => $_POST["email"],
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "status" => "active",
            "created" => date("Y-m-d H:i:s")
        );

$new_user = \system\Data::insert(["data" => $data, "table" => $User->table]);

if($new_user){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    include_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);    
}

exit;
?>
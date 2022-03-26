<?php
$check = array();
include_once(\system\Core::doc_root() . "/system/php/Mail.php");

#CHECK IF USERNAME IS FREE
$check_for_user = $PDO->query("SELECT id FROM " . $User->table . " WHERE username='" . $_POST["username"]. "'AND deleted IS NULL");
if($check_for_user->rowCount()  > 0){ $check["#username"] = $Text->_("This username is already in use");}

#CHECK IF EMAIL IS VALID
if(\system\Mail::validate($_POST["email"]) === false){$check["#email"] = $Text->_("Invalid email format");}

#CHECK IF EMAIL IS NOT USED ALREADY
$check_for_mail = $PDO->query("SELECT id FROM " . $User->table . " WHERE email='" . $_POST["email"]. "'AND deleted IS NULL");
if($check_for_mail->rowCount()  > 0){$check["#email"] = $Text->_("There is user registred with this email");}

#CHECK IF PASSWORD MEET REQUIREMENTS
if($User->pass_requirements($_POST["password"]) != "1"){$check["#password"] = $Text->_("Password requirements are not meet.");}

#CHECK IF PASSWORD MATCHES
if($_POST["password"] != $_POST["repassword"]){$check["#repassword"] = $Text->_("Passwords are not the same");}

if(empty($check)){

#CREATE NEW USERS IF ALL EVERYTHING IS FINE
$activate_code = md5(rand());
$array = array(
            "group" => "guest",
            "username" => $_POST["username"],
            "email" => $_POST["email"],
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "status" => $activate_code,
            "created" => date("Y-m-d H:i:s")
        );
$newUser = \system\Data::insert($array, \system\Data::table());

if($newUser){
    $subject = $Text->item("Successful registration");
    $message = $Text->item("Your new registration is successful. Please visit the link below to activate your new profile.");
    $message .= $User->activation_link($activate_code, $_POST["email"]);
    \system\Mail::send($_POST["email"], $subject, $message);
    ?><script>location.href = '<?php echo \system\Core::url();?>User/message/successful-registration';</script><?php
} else {
    echo $Text->item("Something went wrong");
}

} else {
    \system\Form::validate($check);    
}

exit
?>
<?php
$check = array();

#CHECK IF EMAIL IS VALID
if(\system\Mail::validate($_POST["email"]) === false){$check["#email"] =  $Text->_("Invalid email format");}
if(!empty($check)){\system\Form::validate($check);exit;}

#CHECK IF EMAIL IS USED IN THE SYSTEM
$check_email = $PDO -> query("SELECT * FROM " . \system\Database::table() . " WHERE email='" . $_POST["email"] . "'");
if($check_email->rowCount() === 0){echo $Text->_("This email is not registred"); exit;}

$new_pass = uniqid();
#CHANGE PASSWORD TO USER
$update_password = $PDO->prepare("UPDATE " . \system\Database::table() . " SET password = ? WHERE email LIKE '" . $_POST["email"] . "'");
$update_password->execute(
    array(
        password_hash($new_pass, PASSWORD_DEFAULT)
    ));

if($update_password){
    $subject = $Text->item("Renew password");
    $message = $Text->item("This is your new password: ");
    $message .= $new_pass;
    \system\Mail::send($Setting->_("Title", array("type" => "", "page_id" => 0)), $Setting->_("Email", array("type" => "", "page_id" => 0)), $_POST["email"], $subject, $message);
    ?><script>location.href = '<?php echo \system\Core::url() . "User/message/successful-new-password";?>';</script><?php
} else {
    echo $Text->_("Something went wrong");
}
exit;
?>
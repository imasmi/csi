<?php
echo $Text->item("Your activation code is sended to your email");

#RESEND ACTIVATION LINK
$subject = $Text->item("Activation link");
$message = $Text->item("This is your activation link");
$message .= $User->activation_link($_POST["code"], $_POST["email"]);
$Mail->send($_POST["email"],$subject, $message);
exit;
?>
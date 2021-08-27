<?php
namespace system\php;

class Mail{
    
    public function __construct(){
        global $Core;
        $this->Core = $Core;
    }

#VALIDATE EMAIL  
    public function validate($email){
	    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        } else {
            return false;
        }
	}
	
# SEND EMAIL
    //array possible values: sender => strig(name of the sender), "from" => string(valid email address), "reply-to" => string(valid-email-address)
	public function send($to, $subject, $message, $header = array()){
	    global $Setting;
	    if($this->validate($to) !== false){
	        define('CONFIG_MAIL_FROM', $this->Core->domain());
		
		  // To send HTML mail, the Content-type header must be set
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
		  // Additional headers
		  $headers .= 'From: ' . (isset($header["sender"]) ? $header["sender"] : $Setting->_("Title", array("page_id" => 0))) . ' <' . (isset($header["from"]) ? $header["from"] : $Setting->_("Contact-email", array("page_id" => 0))) . '>' . "\r\n";
		  if(isset($header["reply-to"])){ $headers .= 'Reply-To: ' . $header["reply-to"] . "\r\n";}
		  $headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n";
	
		  $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
	
		  // Mail it
		  mail($to, $subject, $message, $headers);
	    } else {
	        echo 'Invalid email address: ' . $to;
	    }
	}
}

$Mail = new Mail();
?>
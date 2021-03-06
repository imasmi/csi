<?php
$check_user = $PDO -> prepare("SELECT id, username, status, `group`, password, email FROM " . \system\Data::table() . " WHERE username=? AND deleted IS null");
$check_user->execute(array($_POST["username"]));

$check = array();

if($_POST['username'] == ''){
	$check["#username"] =  $Text->item("Insert username");
}

if($_POST['password'] == ''){
	$check["#password"] = $Text->item("Insert password");
} 


if($check_user->rowCount() == 1){
	$login_user = $check_user->fetch();
	$check_password = password_verify($_POST["password"], $login_user["password"]);
	
	if($check_password === false || $login_user["username"] !== $_POST["username"]){
	    $check["#username, #password"] = $Text->item("Wrong username or password");
	} elseif($login_user["status"] === "deactivated"){
    	$check[] = $Text->item("This user is deactivated, please contact site administrator");
    	exit;
    } elseif($login_user["status"] !== "active"){
    	$check[] = $Text->item("This user is not activated.");
    	$check[] = '<input type="button" value="' . $Text->item("Resend activation link") . '" onclick="S.post(\'' . \system\Core::url() . \system\Module::_() . '/query/resend-activation\', {\'code\':\'' . $login_user["status"] . '\',\'email\':\'' . $login_user["email"] . '\'}, \'#error-message\')"/>';
    } else {
	    $_SESSION["id"] = $login_user["id"];
	    $_SESSION["group"] = $login_user["group"];
	    ?><script>location.href = '<?php echo \system\Core::url();?>';</script><?php
    }
} else {
	$check["#username, #password"] = $Text->item("Wrong username or password");
}

if(!empty($check)){
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    $Form = new \system\Form;
    \system\Form::validate($check);
}
exit;
?>
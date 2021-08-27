<?
$check = array();



if($_POST["newpassword"] === ""){$check["#newpassword"] = $Text->_("Insert new password");}
if($_POST["repassword"] === ""){$check["#repassword"] = $Text->_("Retype new password");}
if($_POST["newpassword"] !== $_POST["repassword"]){$check["#newpassword, #repassword"] = $Text->_("Passwords didn't match");}
if($User->pass_requirements($_POST["newpassword"]) != "1"){$check["#newpassword"] = $Text->_("Password requirements are not meet.");}

if(empty($check)){
    $array = array("password" => password_hash($_POST["newpassword"], PASSWORD_DEFAULT));

    $update = $Query->update($array, $_GET["id"]);
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
    
} else {
    $Form->validate($check);
}
?>
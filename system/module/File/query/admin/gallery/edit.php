<?php
$check = "";
$select = $Query->select($_GET["id"]);
if($_POST["tag"] == ""){ $check["#tag"] = "Please insert gallery tag";}

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if($check == ""){
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
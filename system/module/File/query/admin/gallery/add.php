<?php
$FileAPP = new system\module\File\php\FileAPP;
$check = "";
if($_POST["tag"] == ""){ $check["#tag"] = "Insert tag name;";}

if($check == ""){
    $_POST["created"] = date("Y-m-d H:i:s");
    $add_gallery = $Query->insert($_POST);
    if($add_gallery){
        ?><script>history.go(-1)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
     $Form->validate($check);  
}

?>
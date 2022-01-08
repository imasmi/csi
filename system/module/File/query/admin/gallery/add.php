<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($file["page_id"]);
$check = "";
if($_POST["tag"] == ""){ $check["#tag"] = "Insert tag name;";}

if($check == ""){
    $_POST["created"] = date("Y-m-d H:i:s");
    $add_gallery = \system\Database::insert($_POST);
    if($add_gallery){
        ?><script>history.go(-1)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
     \system\Form::validate($check);
}

?>

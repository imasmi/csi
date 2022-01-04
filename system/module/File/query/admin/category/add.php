<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($file["page_id"]);
$check = "";

if($check == ""){
    $add_gallery = \system\Query::insert($_POST);
    if($add_gallery){
        ?><script>history.go(-2)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
     \system\Form::validate($check);
}

?>

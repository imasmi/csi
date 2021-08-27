<?php
$FileAPP = new system\module\File\php\FileAPP;
$check = "";

if($check == ""){
    $add_gallery = $Query->insert($_POST);
    if($add_gallery){
        ?><script>history.go(-2)</script><?php
    } else {
        echo $Text->_("Something went wrong");
    }
} else {
     $Form->validate($check);  
}

?>
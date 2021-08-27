<?php
$FileAPP = new system\module\File\php\FileAPP;
$FileAPP->upload();

if(isset($_POST["method"]) && $_POST["method"] == "post"){
    ?><script>history.go(-1)</script><?php
} else {
    echo '<script>history.go(-2)</script>';
}
?>
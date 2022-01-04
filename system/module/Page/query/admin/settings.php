<?php
require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");
$SettingAPP = new \module\Setting\SettingAPP($_GET["id"]);
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($_GET["id"]);
// THIS VARIANT IS DEPRECATED AND WILL BE REMOVED IN FUTURE EDITIONS
$posts = $_POST;
foreach($posts as $key => $value){
    if(strpos($key, "Og") !== false){
        unset($posts[$key]);
    }
}
$SettingAPP->save($posts);
$FileAPP->upload(array("page_id" => $_GET["id"]));
$FileAPP->upload_edit();
?>
<?php if(isset($_GET["goTo"])){?>
    <script>window.open('<?php echo $_GET["goTo"];?>', '_self');</script>
<?php } else { ?>
    <script>history.go(<?php echo isset($_GET["goBack"]) ? $_GET["goBack"] : -2;?>);</script>
<?php } ?>
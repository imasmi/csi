<?php
// THIS VARIANT IS DEPRECATED AND WILL BE REMOVED IN FUTURE EDITIONS
$posts = $_POST;
foreach($posts as $key => $value){
    if(strpos($key, "Og") !== false){
        unset($posts[$key]);
    }
}
$FileAPP = new system\module\File\php\FileAPP;
$SettingAPP = new \system\module\Setting\php\SettingAPP($_GET["id"]);
$SettingAPP->save($posts);
$FileAPP->upload(array("page_id" => $_GET["id"]));
$FileAPP->upload_edit();
?>
<?php if(isset($_GET["goTo"])){?>
    <script>window.open('<?php echo $_GET["goTo"];?>', '_self');</script>
<?php } else { ?>
    <script>history.go(<?php echo isset($_GET["goBack"]) ? $_GET["goBack"] : -2;?>);</script>
<?php } ?>
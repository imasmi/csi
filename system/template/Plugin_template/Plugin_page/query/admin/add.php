<?php
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;
require_once(\system\Core::doc_root() . "/system/module/Code/php/CodeAPP.php");
$CodeAPP = new \module\Code\CodeAPP;
$check = array();
$Object = $Plugin->object();
$plugin = isset($Object->plugin) ? $Object->plugin : NULL;

#CHECK IF FILE ALREADY EXISTS IN THIS FOLDER
if(isset($_POST["filename"]) && $_POST["filename"] != ""){
    $check_file = $PDO->query("SELECT * FROM " . \system\Query::table() . " WHERE link_id='" . $_POST["link_id"]. "' AND filename='" . $_POST["filename"] . "'");
    if($check_file->rowCount() > 0){ $check["#filename"] = "There is a file with the same nema already.";}
}

if(isset($_POST["filename"])){
    if($CodeAPP->special_characters_check($_POST["filename"]) === true){$check["#filename"] = "Special characters are not allowed.";}
}

foreach($Language->items as $value){
    if($CodeAPP->special_characters_check($_POST[$value]) === true){
        $check["#" . $value] = "Special characters are not allowed.";
    }
}

if(empty($check)){

#ADD NEW PAGE
$array = array(
        "link_id" => isset($_POST["link_id"]) ? $_POST["link_id"] : $Object->link_id,
        "user_id" => $User->id,
        "plugin" => isset($Object->plugin) ? $Object->plugin : NULL,
        "row" => \system\Query::new_id($Page->table, "row", " WHERE link_id='" . $_POST["link_id"] . "'"),
        "menu" => isset($_POST["menu"]) ? $_POST["menu"] : NULL,
        "tag" => $Object->tag,
        "type" => isset($_POST["type"]) ? $_POST["type"] : NULL,
        "created" => date("Y-m-d H:i:s")
);

foreach($Language->items as $key=>$value){
    $array[$value] = (strpos($_POST[$value], "http") !== false) ? $_POST[$value] : $PageAPP->url_format($_POST[$value]);
}

$new_page = \system\Query::insert($array, $Object->table);

if($new_page){
    $id = $PDO->lastInsertId();
    $posts = array();
    foreach($Language->items as $key=>$value){
        $posts["Title_" . $value] = $_POST["Title_" . $value]; 
        $posts["Menu_" . $value] = $_POST["Menu_" . $value]; 
        $posts["Description_" . $value] = $_POST["Description_" . $value]; 
    }
    require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
    $FileAPP = new \module\File\FileAPP($id, array("plugin" => $plugin));
    require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");
    $SettingAPP = new \module\Setting\SettingAPP($id, array("plugin" => $plugin));
    $SettingAPP->save($posts);
    $FileAPP->upload(array("page_id" => $id));
    
    /*
    // Add Title and Menu settings directly with the same content with the language url
    $settings_add = array($id, array("plugin" => $plugin));
    $SettingAPP = new \module\Setting\SettingAPP($id);
    foreach($Language->items as $lang=>$abbrev){
        $settings_add["Title_" . $abbrev] = $_POST[$abbrev];
        $settings_add["Menu_" . $abbrev] = $_POST[$abbrev];
    }
    $SettingAPP->save($settings_add);
    
    // Add Title text directly with the same content with the language url
    $text_add = array(
        "page_id" => $id,
        "plugin" => $plugin,
        "tag" => "Title"
    );
    foreach($Language->items as $lang=>$abbrev){
        $text_add[$abbrev] = $_POST[$abbrev];
    }
    \system\Query::insert($text_add, $Text->table);
    ?>
    <script>window.open('<?php echo $Page->url($id);?>', '_self');</script>
    */
    ?>
        <script>history.go(-2);</script>
    <?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
	require_once(\system\Core::doc_root() . "/system/php/Form.php");
	$Form = new \system\Form;
    \system\Form::validate($check);    
}

exit;
?>
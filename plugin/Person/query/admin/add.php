<?php
$PageAPP = new \system\module\Page\php\PageAPP;
$CodeAPP = new \system\module\Code\php\CodeAPP;
$check = array();
$Object = $Plugin->object();

foreach($Language->items as $value){
    if($CodeAPP->special_characters_check($_POST[$value]) === true){
        $check["#" . $value] = "Special characters are not allowed.";
    }
}

if(empty($check)){

#ADD NEW PAGE

$array = array(
        "link_id" => $Object->link_id,
        "plugin" => isset($Object->plugin) ? $Object->plugin : NULL,
        "row" => $_POST["menu"] != "0" ? \system\Database::new_id($Object->table, "row", " WHERE menu='" . $_POST["menu"] . "'") : 0,
        "menu" => isset($_POST["menu"]) ? $_POST["menu"] : NULL,  
        "tag" => $Object->tag,
        "type" => isset($_POST["type"]) ? $_POST["type"] : NULL, 
        "datetime" => date("Y-m-d H:i:s")
);

foreach($Language->items as $lang=>$abbrev){
    $array[$abbrev] = $PageAPP->url_format($_POST[$abbrev]);
}

$newPage = \system\Database::insert($array, $Object->table);
$id = $PDO->lastInsertId();

if($newPage){
    /*
    // Add Title and Menu settings directly with the same content with the language url
    $plugin = isset($Object->plugin) ? $Object->plugin : NULL;
    $settings_add = array();
    $SettingAPP = new \system\module\Setting\php\SettingAPP($id, array("plugin" => $plugin));
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
    \system\Database::insert($text_add, $Text->table);
    ?>
    <script>window.open('<?php echo $Page->url($id);?>', '_self');</script>
    */
?>
    <script>location.href = '<?php echo \system\Core::url();?>Page/admin/settings?id=<?php echo $id;?>&goBack=-3';</script>
<?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);    
}

exit;
?>
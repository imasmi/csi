<?php
$PageAPP = new \system\module\Page\php\PageAPP;
$CodeAPP = new \system\module\Code\php\CodeAPP;
$check = array();

#CHECK IF FILE ALREADY EXISTS IN THIS FOLDER
if(isset($_POST["filename"]) && $_POST["filename"] != ""){
    $check_file = $PDO->query("SELECT * FROM " . $Query->table() . " WHERE link_id='" . $_POST["link_id"]. "' AND filename='" . $_POST["filename"] . "'");
    if($check_file->rowCount() > 0){ $check["#filename"] = "There is a file with the same nema already.";}
}

if($CodeAPP->special_characters_check($_POST["filename"]) === true){$check["#filename"] = "Special characters are not allowed.";}

foreach($Language->items as $value){
    if($CodeAPP->special_characters_check($_POST[$value]) === true){
        $check["#" . $value] = "Special characters are not allowed.";
    }
}

if(empty($check)){

#ADD NEW PAGE
$array = array(
        "link_id" => $_POST["link_id"],
        "user_id" => $User->id,
        "row" => $Query->new_id($Page->table, "row", " WHERE link_id='" . $_POST["link_id"] . "'" . (isset($_POST["menu"]) ? " AND menu='" . $_POST["menu"] . "'" : "")),
        "menu" => $_POST["menu"],
        "filename" => $PageAPP->url_format($_POST["filename"]), 
        "tag" => $_POST["tag"],
        "created" => date("Y-m-d H:i:s")
);

if($_POST["homepage"] == "on"){
    $PDO->query("UPDATE " . $Query->table() . " SET `type`='' WHERE `type`='homepage'");
    $array["type"] = "homepage";
}

foreach($Language->items as $key=>$value){
    $array[$value] = (strpos($_POST[$value], "http") !== false) ? $_POST[$value] : $PageAPP->url_format($_POST[$value]);
}

$new_page = $Query->insert($array);

if($new_page){
    $id = $PDO->lastInsertId();
    if(isset($_POST["filename"]) && $_POST["filename"] !== ""){
        $dir = $Page->doc_root . '/' . $Page->path($id, true);
        if(!is_dir($dir)){ mkdir($dir, 0755, true);}
        
        $my_file = fopen($Page->doc_root . '/' . $Page->path($id) . ".php", "w") or die("Unable to open file!");
        fclose($my_file);
    }
    
    $posts = array();
    foreach($Language->items as $key=>$value){
        $posts["Title_" . $value] = $_POST["Title_" . $value]; 
        $posts["Menu_" . $value] = $_POST["Menu_" . $value]; 
        $posts["Description_" . $value] = $_POST["Description_" . $value]; 
    }
    $FileAPP = new system\module\File\php\FileAPP($id);
    $SettingAPP = new \system\module\Setting\php\SettingAPP($id);
    $SettingAPP->save($posts);
    $FileAPP->upload(array("page_id" => $id));
    ?>
        <script>history.go(-2);</script>
    <?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);    
}

exit;
?>
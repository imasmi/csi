<?php
$check = array();

foreach ($Theme->items as $theme => $data) {
    if ($_POST["name"] == $theme) {
        $check["#name"] = "There is theme with such name already installed.";
    }
}


if(empty($check)){
    include_once(\system\Core::doc_root() . "/system/php/Ini.php");
    include_once(\system\Core::doc_root() . "/system/module/File/php/ZipAPP.php");
    include_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
    $FileAPP = new \module\File\FileAPP;
    if ($Theme->name) { $Theme->package($Theme->name);}
    $theme_ini = [];
    foreach ($Theme->items as $theme => $data) {
        $data["active"] = 0;
        $theme_ini[$theme] = $data;
    }
    
    $theme_ini[$_POST["name"]] = ["active" => 1, "version" => "1.0"];
    \system\Ini::save(\system\Core::doc_root() . "/web/ini/theme.ini", $theme_ini);
    
    $plugin_ini = [];
    foreach ($Plugin->items as $plugin => $data) {
        if ($data == "*") {
            $plugin_ini[$plugin] = $data;
        } else {
            $FileAPP->delete_dir(\system\Core::doc_root() . "/plugin/" . $plugin);
        }
    }
    \system\Ini::save(\system\Core::doc_root() . "/web/ini/plugin.ini", $plugin_ini);
    
    foreach (\system\Core::list_dir(\system\Core::doc_root() . "/web", ["recursive" => false]) as $node) {
        if(is_file($node)) {
            unlink($node);
        } else {
            $pathinfo = pathinfo($node);
            if ($pathinfo["basename"] == "file" || $pathinfo["basename"] == "ini") { } else { $FileAPP->delete_dir($node); }
        }
    }
    
    $Blank_zip = new \module\File\ZipAPP(\system\Core::doc_root() . "/system/module/Theme/blank/theme.zip", \system\Core::doc_root());
    $Blank_zip->unzip();
    
    $columns = $PDO->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= '" . $database["database"] . "' AND TABLE_NAME = '" . $Page->table . "'")->fetchALL(\PDO::FETCH_COLUMN);
    $info = parse_ini_file(\system\Core::doc_root() . "/system/module/Theme/blank/theme.info", true, INI_SCANNER_RAW);
    $pages = json_decode($info["pages"], true);
    foreach ($pages as $page) {
        $page["theme"] = $_POST["name"];
        $page["created"] = date("Y-m-d H:i:s");
        $page["user_id"] = $User->id;
        foreach ($page as $key => $value) {
            if (!in_array($key, $columns)) { unset($page[$key]);}
        }
        \system\Data::insert($page, $Page->table);
    };
    ?>
    <script>window.open('<?php echo \system\Core::url();?>?Clear-Site-Data="cache"', '_self');</script>
    <?php
} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);
}
exit;
?>
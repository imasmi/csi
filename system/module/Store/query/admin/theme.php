<?php
$check = array();

foreach ($Theme->items as $theme => $data) {
    if ($_GET["name"] == $theme) {
        $check["#name"] = "There is theme with such name already installed.";
    }
}


if(empty($check)){
    $theme_dir = "http://web.imasmi.com/plugin/Webstore/theme/" . $_GET["name"] . "/";
    if (copy($theme_dir . "theme.zip", \system\Core::doc_root() . "/" . $_GET["name"] . ".zip")) {
        $info = parse_ini_string(file_get_contents($theme_dir . "theme.info"), true, INI_SCANNER_RAW);
        $plugins = json_decode($info["plugins"], true);
        
        include_once(\system\Core::doc_root() . "/system/php/Ini.php");
        include_once(\system\Core::doc_root() . "/system/module/File/php/ZipAPP.php");
        include_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
        $FileAPP = new \module\File\FileAPP;
        if ($Theme->active) {$Theme->package($Theme->active);}
        $theme_ini = [];
        foreach ($Theme->items as $theme => $data) {
            $data["active"] = 0;
            $theme_ini[$theme] = $data;
        }
        
        $theme_ini[$_GET["name"]] = ["active" => 1, "version" => $info["version"]];
        \system\Ini::save(\system\Core::doc_root() . "/web/ini/theme.ini", $theme_ini);
        
        $plugin_ini = [];
        foreach ($Plugin->items as $plugin => $data) {
            if ($data == "*") {
                $plugin_ini[$plugin] = $data;
            } else {
                $FileAPP->delete_dir(\system\Core::doc_root() . "/plugin/" . $plugin);
            }
        }
        if (!empty($plugins)) {
            foreach ($plugins as $plugin => $data) {
                $plugin_ini[$plugin] = $data;
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
        
        $Theme_zip = new \module\File\ZipAPP(\system\Core::doc_root() . "/" . $_GET["name"] . ".zip", \system\Core::doc_root());
        $Theme_zip->unzip();
        unlink(\system\Core::doc_root() . "/" . $_GET["name"] . ".zip");
        
        $columns = $PDO->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= '" . $database["database"] . "' AND TABLE_NAME = '" . $Page->table . "'")->fetchALL(\PDO::FETCH_COLUMN);
        $pages = json_decode($info["pages"], true);
        foreach ($pages as $page) {
            $page["theme"] = $_GET["name"];
            $page["created"] = date("Y-m-d H:i:s");
            $page["user_id"] = $User->id;
            foreach ($page as $key => $value) {
                if (!in_array($key, $columns)) { unset($page[$key]);}
            }
            \system\Query::insert($page, $Page->table);
        };
        ?>
        <script>window.open('<?php echo \system\Core::url();?>?Clear-Site-Data="cache"', '_self');</script>
        <?php
    } else {
        ?><h3>Unable to copy theme files. Please try again.</h3><?php
    }
    
} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);
}
exit;
?>
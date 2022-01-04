<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/ZipAPP.php");
require_once(\system\Core::doc_root() . "/system/php/Ini.php");
$fileName = $_GET["name"] . ".zip";
$plugin_dir = $Plugin->doc_root . '/' . $_GET["name"];
$file_path = $plugin_dir . '/' . $fileName;
if(!is_dir($plugin_dir)){mkdir($plugin_dir, 0755, true);}
if (copy("http://web.imasmi.com/plugin/Webstore/plugin/" . $_GET["name"] . "/" . $fileName, $file_path)) {
    $Zip = new \module\File\ZipAPP($file_path, $plugin_dir);
    if($Zip->unzip() !== false){
        unlink($file_path);
        if(!is_dir($plugin_dir . '/ini')){mkdir($plugin_dir . '/ini');}
        copy("http://web.imasmi.com/plugin/Webstore/plugin/" . $_GET["name"] . "/plugin.info", $plugin_dir . '/ini/plugin.ini');
        chmod($plugin_dir . '/ini/plugin.ini', 0640);
        $ini = [$_GET["name"] => [
                "active" => 1,
                "admin-panel" => file_exists($plugin_dir . '/page/admin/index.php') ? 1 : 0,
                "theme" => $Theme->active
            ]
        ];
        \system\Ini::save(\system\Core::doc_root() . "/web/ini/plugin.ini", $ini, FILE_APPEND);
        echo $_GET["name"] . ' is installed successfuly.';
    }
} else {
    ?><h3>Unable to copy plugin files. Please try again.</h3><?php
}
?>
<?php
$fileName = $_GET["name"] . ".zip";
$plugin_dir = $Plugin->doc_root . '/' . $_GET["name"];
$file_path = $plugin_dir . '/' . $fileName;
if(!is_dir($plugin_dir)){mkdir($plugin_dir, 0755, true);}
if (copy("http://web.imasmi.com/plugin/Webstore/plugin/" . $_GET["name"] . "/" . $fileName, $file_path)) {
    $Zip = new \system\module\File\php\ZipAPP($file_path, $plugin_dir);
    if($Zip->unzip() !== false){
        unlink($file_path);
        if(!is_dir($plugin_dir . '/ini')){mkdir($plugin_dir . '/ini');}
        copy("http://web.imasmi.com/plugin/Webstore/plugin/" . $_GET["name"] . "/plugin.ini", $plugin_dir . '/ini/plugin.ini');
        chmod($plugin_dir . '/ini/plugin.ini', 0640);
        $Ini->save($Core->doc_root() . "/web/ini/plugin.ini", array($_GET["name"] => "1"), FILE_APPEND);
        echo $_GET["name"] . ' is installed successfuly.';
    }
} else {
    echo 'Unable to copy file';
}
?>
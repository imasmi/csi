<?php
require_once(\system\Core::doc_root() . "/system/php/Ini.php");
$Ini = new \system\Ini;
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP;
$plugin_name = ucfirst($_POST["name"]);
if(!is_dir($Plugin->doc_root)){mkdir($Plugin->doc_root);}
if(!in_array($plugin_name, scandir($Plugin->doc_root))){
    $new_plugin = $Plugin->doc_root . '/' . $plugin_name;
    mkdir($Plugin->doc_root . '/' . $plugin_name);
    $FileAPP->copy_dir(\system\Core::doc_root() . '/system/template/Plugin_template/Plugin_' . $_POST["type"], $new_plugin);
    rename($new_plugin . "/php/Plugin_" . $_POST["type"] . ".php", $new_plugin . "/php/" . $plugin_name . ".php");
    $module_file = file_get_contents($new_plugin . "/php/" . $plugin_name . ".php");
    $module_file = str_replace("Plugin_" . $_POST["type"], ucfirst($plugin_name), $module_file);
    $module_file = str_replace("plugin_" . $_POST["type"], mb_strtolower($plugin_name), $module_file);
    file_put_contents($new_plugin . "/php/" . $plugin_name . ".php", $module_file);
    
    $plugin_ini = [ 
        $plugin_name => [
            "active" => 1,
            "admin-panel" => isset($_POST["admin-panel"]) && $_POST["admin-panel"] == "on" ? 1 : 0,
            "theme" => isset($_POST["theme"]) && $_POST["theme"] == "on" ? 1 : 0,
        ]
    ];
    
    \system\Ini::save(\system\Core::doc_root() . "/web/ini/plugin.ini", $plugin_ini, FILE_APPEND);
    ?><script>history.go(-1)</script><?php
} else {
    echo 'Plugin with the same name already exists. Please choose another name for your new plugin.';
}
?>
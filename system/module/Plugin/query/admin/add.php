<?php
$FileAPP = new system\module\File\php\FileAPP;
$plugin_name = ucfirst($_POST["name"]);
if(!is_dir($Plugin->doc_root)){mkdir($Plugin->doc_root);}
if(!in_array($plugin_name, scandir($Plugin->doc_root))){
    $new_plugin = $Plugin->doc_root . '/' . $plugin_name;
    mkdir($Plugin->doc_root . '/' . $plugin_name);
    $FileAPP->copy_dir($Core->doc_root() . '/system/template/Plugin_template/Plugin_' . $_POST["type"], $new_plugin);
    rename($new_plugin . "/php/Plugin_" . $_POST["type"] . ".php", $new_plugin . "/php/" . $plugin_name . ".php");
    $module_file = file_get_contents($new_plugin . "/php/" . $plugin_name . ".php");
    $module_file = str_replace("Plugin_" . $_POST["type"], ucfirst($plugin_name), $module_file);
    $module_file = str_replace("plugin_" . $_POST["type"], mb_strtolower($plugin_name), $module_file);
    file_put_contents($new_plugin . "/php/" . $plugin_name . ".php", $module_file);
    $Ini->save($Core->doc_root() . "/web/ini/plugin.ini", array($plugin_name => isset($_POST["admin-panel"]) && $_POST["admin-panel"] == "on" ? 2 : 1), FILE_APPEND);
    ?><script>history.go(-1)</script><?php
} else {
    echo 'Plugin with the same name already exists. Please choose another name for your new plugin.';
}
?>
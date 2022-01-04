<?php
require_once(\system\Core::doc_root() . "/system/php/Ini.php");
$Ini = new \system\Ini;

$plugins_array = array();
foreach($_POST as $plugin => $value){
    if(strpos($plugin, "_admin-panel") === false && strpos($plugin, "_theme") === false){
        $plugins_array[$plugin] = ["active" => $_POST[$plugin], "admin-panel" => $_POST[$plugin . "_admin-panel"], "theme" => $_POST[$plugin . "_theme"]];
    }
}
\system\Ini::save(\system\Core::doc_root() . "/web/ini/plugin.ini", $plugins_array);
?>
<script>history.back();</script>
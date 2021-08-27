<?php
$plugins_array = array();
foreach($Plugin->items as $plugin => $value){
    $plugins_array[$plugin] = $_POST[$plugin] == 0 ? 0 : ($_POST[$plugin . "_show"] == 1 ? 2 : 1);
}
$Ini->save($Core->doc_root() . "/web/ini/plugin.ini", $plugins_array);
?>
<script>history.back();</script>
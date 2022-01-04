<?php
if (in_array("query", \system\Core::links())){

    $link = \system\Core::links();
    #check for user role permission in current location path
    foreach($User->column_group as $role){
        if(in_array(strtolower($role),  $link)){ $User->control("admin");}
    }

    if(\system\Module::_() !== false){
        $file = \system\Core::path_resolve("/system/module/" .  $_GET["url"] . ".php");
    } elseif($Plugin->_() !== false){
        $file = \system\Core::path_resolve("/plugin/" .  $_GET["url"] . ".php");
    } else {
        $file = \system\Core::path_resolve("/web/" . $_GET["url"] . ".php");
    }
    require_once($file);
    exit;
}
?>

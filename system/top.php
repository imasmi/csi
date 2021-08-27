<?php
if (in_array("query", $Core->links())){
    
    $link = $Core->links();
    #check for user role permission in current location path
    foreach($User->roles as $role){
        if(in_array(strtolower($role),  $link)){ $User->control("admin");}
    }
    
    if($Module->_() !== false){
        $file = $Core->path_resolve("/system/module/" .  $_GET["url"] . ".php");
    } elseif($Plugin->_() !== false){
        $file = $Core->path_resolve("/plugin/" .  $_GET["url"] . ".php");
    } else {
        $file = $Core->path_resolve("/web/" . $_GET["url"] . ".php");
    }
    require_once($file);
    exit;
}
?>
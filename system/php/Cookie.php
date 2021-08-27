<?php
namespace system\php;

class Cookie{
    public function set($name, $value, $array=array()){
        $array["expires"] = isset($array["expires"]) ? $array["expires"] : time() + (86400 * 30);
        $array["path"] = isset($array["path"]) ? $array["path"] : "/";
        setcookie($name, $value, $array["expires"], $array["path"]);
    }
    
    public function remove($name, $array=array()){
        $array["path"] = isset($array["path"]) ? $array["path"] : "/";
        setcookie($name, "", time() - 3600, $array["path"]);
    }
}

$Cookie = new Cookie;
?>
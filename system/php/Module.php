<?php
namespace system;

class Module{
    public static function items() {
        return parse_ini_file(\system\Core::doc_root() . "/system/ini/module.ini");
    }
    
    public static function _() {
        $link = \system\Core::links();
        $items = static::items();
        foreach($items as $key => $module){
            if(mb_strtolower($key) == mb_strtolower($link[0])){
                return $key;
            }
        }
        return false;
    }
}
?>

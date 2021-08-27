<?php
namespace system\php;

class Module{
    public function __construct($modules){
        global $Core;
        $this->Core = $Core;
        global $Ini;
        $this->modules = $modules;
    }
    
    public function _(){
        $link = $this->Core->links();
        foreach($this->modules as $key => $module){
            if(mb_strtolower($key) == mb_strtolower($link[0])){
                return $key;
            }
        }
        return false;
    }
}

$Module = new Module($modules);
?>
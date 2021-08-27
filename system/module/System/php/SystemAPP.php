<?php
namespace system\module\System\php;

class SystemAPP{
    public function __construct(){
        global $Core;
        $this->Core = $Core;
        $this->ini = parse_ini_file($this->Core->doc_root() . "/system/ini/system.ini");
        $this->backup_dir = $this->Core->doc_root() . "/data/backup/";
    }
}
?>
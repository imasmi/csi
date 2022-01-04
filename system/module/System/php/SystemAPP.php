<?php
namespace module\System;

class SystemAPP{
    public function __construct(){
        $this->ini = parse_ini_file(\system\Core::doc_root() . "/system/ini/system.ini");
        $this->backup_dir = \system\Core::doc_root() . "/data/backup/";
    }
}
?>

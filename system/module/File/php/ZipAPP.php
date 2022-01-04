<?php
namespace module\File;
/**
 * Class to work with zip files (using ZipArchive)
 */

class ZipAPP{
    //Array possible values
    //include => string | array (single directory/file or array of directories/files)
    //exclude => string | array (single directory/file or array of directories/files)
    public function __construct($file, $path, $array=array())
    {
        $this->zip = new \ZipArchive();
        $this->file = $file;
        $this->path = $path;
        $this->arr = $array;
    }

    public function create(){
        $res = $this->zip->open($this->file, \ZipArchive::CREATE);
        if ($res !== true){
            return false;
        }

        $nodes = isset($this->arr["include"]) ? $this->arr["include"] : $this->path;
        $nodes = is_array($nodes) ? $nodes : array($nodes);

        $exclude = isset($this->arr["exclude"]) ? (is_array($this->arr["exclude"]) ? $this->arr["exclude"] : array($this->arr["exclude"])) : false;

        foreach($nodes as $node){
            $node = is_dir($node) ? \system\Core::list_dir($node) : array($node);
            foreach($node as $addon){
                $add_to_archive = true;
                if($exclude !== false){foreach($exclude as $check){if(strpos($addon, $check) !== false){$add_to_archive = false;}}}

                if($add_to_archive === true){
                    if(is_dir($addon)){
                        $this->zip->addEmptyDir(str_replace($this->path  . "/", "", $addon));
                    } else {
                        $this->zip->addFile($addon, str_replace($this->path  . "/", "", $addon));
                    }
                }
            }
        }

        return $this->zip->close();
    }

    public function unzip()
    {
        $res = $this->zip->open($this->file);
        if ($res !== true) {
            return false;
        }
        if ($this->zip->extractTo($this->path)){
            $this->zip->close();
            return true;
        }
        return false;
    }
}
?>

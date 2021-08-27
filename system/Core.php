<?php
namespace system\core;

class Core{
    public function __construct(){
        $this->links = $this->links();
    }
    
    public function domain(){
        return $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"];
    }
    
    public function list_dir($dir, $array=array()){
		$dir = rtrim($dir, "/");
        $files = array();
        $select = isset($array["select"]) ? $array["select"] : false;
        if(is_dir($dir)){
            $list = scandir($dir);
            unset($list[0]);
            unset($list[1]);
            $fls = array();
            foreach($list as $ls){
                $result = $dir . '/' . $ls;
                if(is_dir($result)){
                    if(isset($array["multidimensional"])){
                        $files[$dir . '/' . $ls] = $this->list_dir($result, $array);
                    } else {
                        if($select === false || $select == "dir"){$files[mb_strtolower($dir . '/' . $ls)] = $result;}
                        if(!isset($array["recursive"]) || $array["recursive"] != false){
                            $output = $this->list_dir($result, $array);
                            $files = array_merge($files, $output);
                        }
                    }
                } else {
                    if(strpos($ls, "APP") !== false){
                       if(isset($_SESSION["role"]) && $_SESSION["role"] =="admin" && ($select === false || $select == "file")){ $fls[mb_strtolower($dir . '/' . $ls)] = $result;}
                    } else {
                        if($select === false || $select == "file"){ $fls[mb_strtolower($dir . '/' . $ls)] = $result;}
                    }
                }
            }
            $files = array_merge($files, $fls);
        }
        return $files;
    }
    
    public function path_resolve($link = false){
        $path = $this->doc_root();
        $node = explode("/", $link);
        $nodes = count($node);
        
        for($a = 1; $a < $nodes; ++$a){
            $list_dir = $this->list_dir($path, array("recursive" => false));
            $location = mb_strtolower($path . "/" . $node[$a]);
            if(array_key_exists($location, $list_dir)){
                $path = $list_dir[$location];
            } else {
                return false;
            }
        }
        return $path;
    }
    
    public function links(){
        if(isset($_GET["url"])){
            $links = explode("/", $_GET["url"]);
            return array_map('strtolower', $links);
        }
        return array();
    }
    
    public function path_slice($path, $start=false, $end=false){
        $links = explode("/", $path);
        if($start !== false && $end !== false){
            $output = array_slice($links, $start, $end);
        } elseif($start !== false){
            $output = array_slice($links, $start);
        } else {
            $output = $links;
        }
        
        return implode("/", $output);
    }
    
    public function this_path($start = false, $end = false){
        return $this->url() . $this->path_slice($_GET["url"], $start, $end);
    }
    
    public function query_path($start = false, $end = false){
		global $Module;
		global $Plugin;
		$check_module = $Module->_();
		$check_plugin = $Plugin->_();
		$links = $this->links();
		
		$pre = "";
		if($check_module !== false){
			$pre = $check_module . "/";
			unset($links[0]);
		} elseif($check_plugin !== false){
			$pre = $check_plugin . "/";
			unset($links[0]);
		}
        return $this->url() . $this->path_slice($pre . "query/" . implode("/", $links), $start, $end);
    }
	
	public function url(){
	    return rtrim($_SERVER["PHP_SELF"], "index.php");
	}
	
	public function doc_root(){
	    return str_replace("/index.php", "", $_SERVER["SCRIPT_FILENAME"]);
	}
	
	public function credit(){
	    return '<div class="credit-system">Developed by <a class="name_system" href="https://imasmi.com" target="_blank" title="ImaSmi software and development">ImaSmi</a></div>';
	}
}

$Core = new Core;
?>
<?php
namespace module\Code;

class CodeAPP{
    public static function find($code, $path, $file_type = "*"){
        $output = array();
        foreach(\system\Core::list_dir($path) as $file){
            $file_info = pathinfo($file);
            if(is_file($file)){
                if($file_type == "*" || (isset($file_info["extension"]) && $file_type == $file_info["extension"])){
                    $finded = substr_count(file_get_contents($file), $code);
                    if($finded > 0){
                        $output[$file] = $finded;
                    }
                }
            }
        }
        return $output;
    }

    public static function replace($code, $replacer, $path, $file_type = "*"){
        $output = array();
        foreach(static::find($code, $path, $file_type) as $file=>$count){
            if(!file_put_contents($file, str_replace($code, $replacer, file_get_contents($file)))){
                $output[] = 'Operation failed in ' . $file . ' where ' . $count . ' occurences was found.';
            } else {
                $output[] = 'Operation succeeded in ' . $file . ' where ' . $count . ' occurences was found.';
            }
        }
        return $output;
    }

    public static function find_between($start, $end, $path, $file_type = "*"){
        $output = array();
        foreach(\system\Core::list_dir($path) as $file){
            $file_info = pathinfo($file);
            if($file_type == "*" || $file_info["extension"] == $file_type){
                $str = file_get_contents($file);
                foreach(explode($start, $str) as $key=>$value){
                    if($key > 0){
                        $cut = explode($end, $value);
                        $output[] = array($cut[0], $file);
                    }
                }
            }
        }
        return $output;
    }

    public static function edit_css($selector, $arr, $source=false){
        $file = ($source === false) ? \system\Core::doc_root() . '/web/css/custom.css' : $source;
        touch($file);
        $css = file_get_contents($file);
        foreach($arr as $key=>$value){
    		if (strpos($css, $selector) === false){
    			$css = $css . "\n" . $selector . "{" . $key . ":" . $value . ";}";
    		} else {
    		    $cutCSS = explode($selector, $css);
    		    $between = explode("}", $cutCSS[1]);
    		    $line = ltrim($between[0], "{");
    		    $count = 0;
    		    $outline = preg_replace("/" . $key . ":(.*?);/", $key . ":" . $value . ";", $line, -1, $count);
    		    if($count == 0){
    		        $outline = $line . $key . ":" . $value . ";";
    		    }
    		    unset($between[0]);
    		    $css = $cutCSS[0] . $selector . "{" . $outline . "}" . implode("}", $between);
    		}
        }

		file_put_contents($file, $css);
	}



    public static function special_characters_check($string){
        return (preg_match('/[\'^£$%&*()}{@#~?><>,|=¬]/', $string)) ? true : false;
    }

    public static function special_characters_remove($string){
        $search = array('/','\\',':',';','!','@','#','$','%','^','*','(',')','=','|','{','}','[',']','"',"'",'<','>',',','?','~','`','&',' ','.');
        return str_replace($search, "", $string); // Removes special chars.
    }
}
?>

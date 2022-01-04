<?php
namespace system;

class Ini{
    public static function format($array){
        $output = "";
        $cnt = 1;
        $total = count($array);
        foreach($array as $key => $file){
            if(is_array($file)){
                $output .= "[" . $key . "]";
                foreach($file as $subkey => $subfile){
                    $output .= "\n" . $subkey . " = " . $subfile;
                }
                if ($cnt != $total) { $output .= "\n\n";}
            } else {
                $output .= $key . " = " . $file;
                if ($key != $total) { $output .= "\n"; }
            }
            $cnt++;
        }
        return $output;
    }

    public static function save($file, $array, $flag=false){
        $chmod = !file_exists($file);
        if ($flag === false) {
            $new_file = file_put_contents($file, static::format($array));
        } else {
            $prelines = is_array($array[key($array)]) ? "\n\n" : "\n";
            $new_file = file_put_contents($file, $prelines . static::format($array), $flag);
        }
        if ($chmod) {chmod($file, 0640);}
        return $new_file;
    }
}
?>

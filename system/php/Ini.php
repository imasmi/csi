<?php
namespace system\php;

class Ini{
    public function format($array){
        $output = "";
        foreach($array as $key => $file){
            if(is_array($file)){
                $output .= "\n[" . $key . "]";
                foreach($file as $subkey => $subfile){
                    $output .= "\n" . $subkey . " = " . $subfile;
                }
            } else {
                $output .= "\n" . $key . " = " . $file;
            }
        }
        return $output;
    }
    
    public function save($file, $array, $flag=false){
        if(!file_exists($file)){
            $new_file = $flag === false ? file_put_contents($file, $this->format($array)) : file_put_contents($file, $this->format($array), $flag);
            chmod($file, 0640);
            return $new_file;
        } else {
            return $flag === false ? file_put_contents($file, $this->format($array)) : file_put_contents($file, $this->format($array), $flag);
        }
    }
}

$Ini = new Ini();
?>
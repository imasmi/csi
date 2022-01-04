<?php
namespace module\Language;

class Language{

    public function __construct(){
        $this->ini_path = \system\Core::doc_root() . "/web/ini/language.ini";
        $this->ini = parse_ini_file($this->ini_path, true);
        $this->items = $this->items();
        if(!isset($_COOKIE["language"]) || !in_array($_COOKIE["language"], $this->items)){
            global $Cookie;
            $lang = $this->items[key($this->items)];
            \system\Cookie::set("language", $lang);
            $_COOKIE["language"] = $lang;
        }
    }

    public function items($show_all = false){
        $output = array();
        if(is_array($this->ini)){
            foreach($this->ini as $key => $value){
                if($value["active"] == "1" || $show_all === true){$output[$key] = $value["code"];}
            }
        }
        return $output;
    }

    public function changer($array=array()){
        global $Page;
        $languages = $this->items;

        if(count($languages) > 1){
            $output = '<div class="languages">';
            foreach ($languages as $lang => $code){
                $output .= '<a href="' . \system\Core::url() . 'Language/query/change?language=' . $code . '&page=' . $Page->id . '" ' . ($this->_() == $code ? 'class="active"' : '') . '>' . ((isset($array["name"])) ? $lang : $code) . '</a>';
            }
            $output .= '</div>';
        }
        return $output;
    }

    public function table(){
        return array("file", "page", "text", "setting");
    }

    public static function _(){
        return isset($_COOKIE["language"]) ? $_COOKIE["language"] : false;
    }
}
?>

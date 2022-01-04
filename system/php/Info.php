<?php
namespace system;

class Info{
    public static function _($text){
        return '<div class="info" onclick="S.info(\''. str_replace('"', "&#34;", $text) . '\')">?</div>';
    }
}
?>

<?php
namespace system\module\Info\php;

class Info{
    public function _($text){
        return '<div class="info" onclick="S.info(\''. str_replace('"', "&#34;", $text) . '\')">?</div>';
    }
}
$Info = new Info;
?>
<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new module\File\FileAPP;
$array = array();
$order = array();

foreach($_POST as $key => $value){
    if(strpos($key, "_code") !== false){
        $name = rtrim($key, "code");
        $nm = rtrim($name, "_");
        $array[$nm] = array(
            "active" => $_POST[$nm . "_active"],
            "code" => $_POST[$nm . "_code"]
        );

        $order[$_POST[$nm . "_position"]] = $nm;
    }
}
ksort($order);


$output = "";
foreach($order as $lang){
    $output .= "\r\n[" . $lang . "]\r\n";
    foreach($array[$lang] as $key1 => $value1){
        $output .= $key1 . " = " . $value1 . "\r\n";
    }
}

file_put_contents(\system\Core::doc_root() . "/web/ini/language.ini", $output);
?><script>history.go(-1)</script><?php
?>

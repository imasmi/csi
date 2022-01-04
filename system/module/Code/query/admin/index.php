<?php
require_once(\system\Core::doc_root() . "/system/module/Code/php/CodeAPP.php");
$file_type = ($_POST["filetype"] == "") ? "*" :  $_POST["filetype"];
$path = \system\Core::doc_root() . '/' . $_POST["path"];

echo 'Find: ' . $_POST["code"] . '<br/>';
if($_POST["action"] == "replace"){echo 'Replace: ' . $_POST["replacer"] . '<br/>';}
if($_POST["filetype"] != ""){echo 'Filetype: ' . $_POST["filetype"] . '<br/>';}
echo 'Location: ' . $path . '<br/><br/>';


if($_POST["action"] == "find"){
    $code = \module\Code\CodeAPP::find($_POST["code"], $path, $file_type);
    $cnt = 1;
    foreach($code as $file => $count){
        echo  '<div>' . $cnt . ': ' . $file . ' (' . $count . ' matches)</div>';
        $cnt++;
    }

    echo '<br/>' . array_sum($code) . " matches in " . count($code) . " files";


} elseif($_POST["action"] == "replace"){
    $code = \module\Code\CodeAPP::replace($_POST["code"], $_POST["replacer"], $path, $file_type);
    foreach($code as $cnt => $log){
        echo  '<div>' . $cnt . ': ' . $log . '</div>';
    }
}


?>

<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new module\File\FileAPP;
$ini = $Language->ini;
#CHECK IF THERE IS MORE THAN ONE LANGUAGE
if(count($ini) < 2){
    echo 'You must have at least one language!';
    exit;
}

$abbreviation = $ini[$_GET["lang"]]["code"];

#REMOVE LANGUAGE COLUMN FROM TABLES
foreach($Language->table() as $table){
    $delet_column = $PDO->query("ALTER TABLE `" . \system\Database::table($table) . "` DROP `" . $abbreviation . "`");
}


#REMOVE LANGUAGE FROM INI FILE
unset($ini[$_GET["lang"]]);

#SET LANGUAGE TO THE FIRST AVAILABLE
$languages = $Language->items();
\system\Cookie::set("language", $languages[key($languages)]["abbreviation"]);

$output = "";
foreach($ini as $lang => $fields){
    $output .= "\r\n[" . $lang . "]\r\n";
    foreach($fields as $key1 => $value1){
        $output .= $key1 . " = " . $value1 . "\r\n";
    }
}

file_put_contents(\system\Core::doc_root() . "/web/ini/language.ini", $output);
?><script>history.go(-1)</script><?php
?>

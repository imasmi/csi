<?php
$check = array();
$ini = parse_ini_file(\system\Core::doc_root() . "/system/ini/languages.ini");
$ini["Norwegian"] = "no";
$ini = array_flip($ini);

#CHECK IF NAME IS NOT EMPTY
if($_POST["language"] === "0"){ $check["#language"] = "Select language.";}

if(empty($check) && !empty($_POST)){
    $output = "[" . $ini[$_POST["language"]] . "]\r\n";
    $output .= "active = 1\r\n";
    $output .= "code = " . $_POST["language"] . "\r\n";
    
    if(file_put_contents($Language->ini_path, $output, FILE_APPEND)){
        foreach($Language->table() as $table){
            $add_column = $PDO->query("ALTER TABLE `" . \system\Query::table($table) ."` ADD `" . $_POST["language"] . "` " . ($table == "text" ? "MEDIUMTEXT" : "TEXT") . " NULL");
        }
    }
    ?><script>history.go(-1)</script><?php
    
} else {
    \system\Form::validate($check);    
}

?>
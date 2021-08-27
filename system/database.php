<?php 
session_start();

/* DATABASE CONFIGURATION */
if(file_exists($Core->doc_root() . "/web/ini/database.ini")){
    $database = parse_ini_file($Core->doc_root() . "/web/ini/database.ini");
} else {
    require_once($Core->doc_root() . "/system/module/System/install/index.php");
    exit;
}
/* DATABASE CONFIGURATION */
$port = isset($database["port"]) ? "port=" . $database["port"] . ";" : "";
try {
    $PDO = new PDO('mysql:host=' . $database["host"] . ';' . $port . 'dbname=' . $database["database"], $database["user"], $database["password"]);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$PDO->exec("set names utf8");
} catch (PDOException $e){
    ?>
        <h2>Database connection error</h2>
        <div>Database INI file exists (/web/ini/database.ini), but the system can not connect to the database. Maybe database server is not available at the moment or because misconfiguration problems.</div>
        <div>Edit /web/ini/database.ini manually or click reset to create new database configuration.</div>
        <button onclick="window.open('?system=reset', '_self')">RESET</button>
    <?php
    exit;
}
?>
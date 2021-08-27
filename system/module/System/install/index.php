<?php 
$root = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
$database_ini = $root . "/web/ini/database.ini";

if(!file_exists($database_ini)){
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Imasmi web</title>
</head>

<body>
<?php 
    if(!isset($_GET["page"])){
        require_once("pages/hello.php");
    } else {
        require_once("pages/" . $_GET["page"] . ".php");
    }
?>
</body>

</html>
<?php } ?>
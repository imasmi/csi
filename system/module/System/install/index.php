<?php 
$database_ini = \system\Core::doc_root() . "/web/ini/database.ini";
if(!file_exists($database_ini)){
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ImaSmi Web</title>
<link rel="stylesheet" href="<?php echo \system\Core::url();?>system/css/WebCss.css">
<style>
    .color-1{color: #6a0000;}
    .color-2 { color: #e78f16;}
    .button {background-color:#6a0000;}
    .button:hover {background-color:#e78f16;}
</style>
</head>

<body class="black-bg white">
    <div class="admin">
        <div class="text-center"><img src="<?php echo \system\Core::url();?>system/file/web-logo.png"></div>
        <?php 
            if(!isset($_GET["page"])){
                require_once("pages/hello.php");
            } else {
                require_once("pages/" . $_GET["page"] . ".php");
            }
        ?>
    </div>
</body>

</html>
<?php } ?>
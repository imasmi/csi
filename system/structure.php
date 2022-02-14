<?php
//$time_start = microtime(true);
require_once("php/Core.php");
require_once("database.php");

//system define.php file
$file = getcwd() . '/system/define.php';
if(file_exists($file)){require_once($file);}

$modules = \system\Module::items();

//location: module/{plugin name} - add module code here
foreach($modules as $module=>$mod_value){
    $file = getcwd() . "/system/module/" . $module . "/define.php";
    if(file_exists($file)){require_once($file);}
}

//location: plugin/{plugin name} - add module code here
foreach($Plugin->items as $plugin=>$value){
    $file = getcwd() . "/plugin/" . $plugin . "/define.php";
    if(file_exists($file)){require_once($file);}
}

//CLASS FILES FROM web FOLDER
$file = getcwd() . '/web/define.php';
if(file_exists($file)){require_once($file);}

if (in_array("query", \system\Core::links())){
  require_once("query.php");
}
?>

<!DOCTYPE html>
<html>
<html lang="<?php echo $Language->_();?>">
<head>
<?php
$file = getcwd() . '/system/head.php';
if(file_exists($file)){require_once($file);}
//location: module/{plugin name} - add plugin code here
foreach($modules as $module=>$mod_value){
    $file = getcwd() . "/system/module/" . $module . "/head.php";
    if(file_exists($file)){require_once($file);}
}
//location: module/{plugin name} - add module code here
foreach($Plugin->items as $plugin=>$value){
    $file = getcwd() . "/plugin/" . $plugin . "/head.php";
    if(file_exists($file)){require_once($file);}
}
$file = getcwd() . '/web/head.php';
if(file_exists($file)){require_once($file);}
?>

</head>

<?php
$file = getcwd() . '/web/body.php';
if(file_exists($file)){
    require_once($file); //
} else { ?>
<body>
<?php } ?>

<?php
if($User->group("admin") && $Theme->name){require_once("admin-panel.php");}

//get layout files
$layouts = array();
foreach(array("header", "index", "footer") as $layout){
    $file = getcwd() . '/system/' . $layout . '.php';
    if(file_exists($file)){$layouts[$layout][] = $file;}
    //location: modules/{plugin name} - add module code here
    foreach($modules as $module=>$mod_value){
        $file = getcwd() . "/system/module/" . $module . "/" . $layout . ".php";
        if(file_exists($file)){$layouts[$layout][] = $file;}
    }
    //location: plugin/{plugin name} - add module code here
    foreach($Plugin->items as $plugin=>$value){
        $file = getcwd() . "/plugin/" . $plugin . "/" . $layout . ".php";
        if(file_exists($file)){$layouts[$layout][] = $file;}
    }
    $file = getcwd() . '/web/' . $layout . '.php';
    if(file_exists($file)){$layouts[$layout][] = $file;}
}

foreach($layouts as $layout => $files){
    ?>
        <div id="<?php echo $layout;?>">
            <?php foreach($files as $file){require_once($file);}?>
        </div>
    <?php
}

//system defer.php file
$file = getcwd() . '/system/defer.php';
if(file_exists($file)){require_once($file);}

//location: module/{plugin name} - add module code here
foreach($modules as $module=>$mod_value){
    $file = getcwd() . "/system/module/" . $module . "/defer.php";
    if(file_exists($file)){require_once($file);}
}

//location: plugin/{plugin name} - add module code here
foreach($Plugin->items as $plugin=>$value){
    $file = getcwd() . "/plugin/" . $plugin . "/defer.php";
    if(file_exists($file)){require_once($file);}
}

//CLASS FILES FROM web FOLDER
$file = getcwd() . '/web/defer.php';
if(file_exists($file)){require_once($file);}
?>
</body>
</html>

<?php
/*
$time_end = microtime(true);
$time = $time_end - $time_start;

echo $time . "<br/>";
echo memory_get_usage() . "<br/>"; // 36640
*/
?>
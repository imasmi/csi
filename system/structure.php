<?php
//$time_start = microtime(true);

require_once("Core.php");
require_once("database.php");

#LOAD MODULES
$modules = parse_ini_file($Core->doc_root() . "/system/ini/module.ini");
$plugins = file_exists($Core->doc_root() . "/web/ini/plugin.ini") ? parse_ini_file($Core->doc_root() . "/web/ini/plugin.ini") : array();

error_reporting(E_ALL ^ E_NOTICE);

#CLASS FILES FROM class FOLDERS
foreach($Core->list_dir("system/php/", array("select" => "file")) as $code){ require_once($code);}

#location: /admin/module/php/{class file name}
foreach($modules as $module=>$mod_value){foreach($Core->list_dir("system/module/" . $module . "/php/", array("select" => "file")) as $code){ require_once($code);}}

#location: plugin/php/{class file name}
foreach($plugins as $plugin=>$value){foreach($Core->list_dir("plugin/" . $plugin . "/php/", array("select" => "file")) as $code){ require_once($code);}}
#location: web/php/{class file name}
foreach($Core->list_dir("web/php/", array("select" => "file")) as $code){ require_once($code);}

#CORE top.php file
$file = getcwd() . '/system/top.php';
if(file_exists($file)){require_once($file);}

#location: module/{plugin name} - add module code here
foreach($modules as $module=>$mod_value){
    $file = getcwd() . "/system/module/" . $module . "/top.php";
    if(file_exists($file)){require_once($file);}
}

#location: plugin/{plugin name} - add module code here
foreach($plugins as $plugin=>$value){
    $file = getcwd() . "/plugin/" . $plugin . "/top.php";
    if(file_exists($file)){require_once($file);}
}

#CLASS FILES FROM web FOLDER
$file = getcwd() . '/web/top.php';
if(file_exists($file)){require_once($file);}
?>

<!DOCTYPE html>
<html>
<html lang="<?php echo $Language->_();?>">
<head>
<?php
$file = getcwd() . '/system/head.php';
if(file_exists($file)){require_once($file);}
#location: module/{plugin name} - add plugin code here
foreach($modules as $module=>$mod_value){
    $file = getcwd() . "/system/module/" . $module . "/head.php";
    if(file_exists($file)){require_once($file);}
}
#location: module/{plugin name} - add module code here
foreach($plugins as $plugin=>$value){
    $file = getcwd() . "/plugin/" . $plugin . "/head.php";
    if(file_exists($file)){require_once($file);}
}
$file = getcwd() . '/web/head.php';
if(file_exists($file)){require_once($file);}

foreach($Core->list_dir("system/css/", array("select" => "file")) as $css){ echo '<link rel="stylesheet" type="text/css" href="' . $Core->url() . $css . '">';}
#location: module/css/{plugin css file name} - add module code here
foreach($modules as $module=>$mod_value){
    foreach($Core->list_dir("system/module/" . $module . "/css/", array("select" => "file")) as $css){ echo '<link rel="stylesheet" type="text/css" href="' . $Core->url() . $css . '">';}
}
#location: plugin/css/{plugin css file name} - add plugin code here
foreach($plugins as $plugin=>$value){
    foreach($Core->list_dir("plugin/" . $plugin . "/css/", array("select" => "file")) as $css){ echo '<link rel="stylesheet" type="text/css" href="' . $Core->url() . $css . '">';}
}
foreach($Core->list_dir("web/css/", array("select" => "file")) as $css){ echo '<link rel="stylesheet" type="text/css" href="' . $Core->url() . $css . '">';}


foreach($Core->list_dir("system/js/", array("select" => "file")) as $js){ echo '<script src="' . $Core->url() . $js . '" defer></script>';}
#location: module/js/{plugin js file name} - add module code here
foreach($modules as $module=>$mod_value){
    foreach($Core->list_dir("system/module/" . $module . "/js/", array("select" => "file")) as $js){ echo '<script src="' . $Core->url() . $js . '" defer></script>';}
}
#location: plugin/js/{plugin js file name} - add plugin code here
foreach($plugins as $plugin=>$value){
    foreach($Core->list_dir("plugin/" . $plugin . "/js/", array("select" => "file")) as $js){ echo '<script src="' . $Core->url() . $js . '" defer></script>';}
}
foreach($Core->list_dir("web/js/", array("select" => "file")) as $js){ echo '<script src="' . $Core->url() . $js . '" defer></script>';}
?>

</head>

<body>
<?php
if($User->_() == "admin"){require_once("admin-panel.php");}

#get layout files
$layouts = array();
foreach(array("header", "index", "footer") as $layout){
    $file = getcwd() . '/system/' . $layout . '.php';
    if(file_exists($file)){$layouts[$layout][] = $file;}
    #location: modules/{plugin name} - add module code here
    foreach($modules as $module=>$mod_value){
        $file = getcwd() . "/system/module/" . $module . "/" . $layout . ".php";
        if(file_exists($file)){$layouts[$layout][] = $file;}
    }
    #location: plugin/{plugin name} - add module code here
    foreach($plugins as $plugin=>$value){
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
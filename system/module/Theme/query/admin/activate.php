<?php
include_once(\system\Core::doc_root() . "/system/php/Ini.php");
include_once(\system\Core::doc_root() . "/system/module/File/php/ZipAPP.php");
include_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP;
$Theme->package($Theme->name);
$info = parse_ini_file(\system\Core::doc_root() . "/data/theme/" . $_GET["theme"] . "/theme.info", true, INI_SCANNER_RAW);
$plugins = json_decode($info["plugins"], true);

$theme_ini = [];
foreach ($Theme->items as $theme => $data) {
    $data["active"] = $_GET["theme"] == $theme ? 1 : 0;
    $theme_ini[$theme] = $data;
}
\system\Ini::save(\system\Core::doc_root() . "/web/ini/theme.ini", $theme_ini);


$plugin_ini = [];
foreach ($Plugin->items as $plugin => $data) {
    if ($data == "*") {
        $plugin_ini[$plugin] = $data;
    } else {
        $FileAPP->delete_dir(\system\Core::doc_root() . "/plugin/" . $plugin);
    }
}
if (!empty($plugins)) {
    foreach ($plugins as $plugin => $data) {
        $plugin_ini[$plugin] = $data;
    }
}
\system\Ini::save(\system\Core::doc_root() . "/web/ini/plugin.ini", $plugin_ini);

foreach (\system\Core::list_dir(\system\Core::doc_root() . "/web", ["recursive" => false]) as $node) {
    if(is_file($node)) {
        unlink($node);
    } else {
        $pathinfo = pathinfo($node);
        if ($pathinfo["basename"] == "file" || $pathinfo["basename"] == "ini") { } else { $FileAPP->delete_dir($node); }
    }
}

$Theme_zip = new \module\File\ZipAPP(\system\Core::doc_root() . "/data/theme/" . $_GET["theme"] . "/theme.zip", \system\Core::doc_root());
$Theme_zip->unzip();
?>
<script>window.open('<?php echo \system\Core::url();?>?Clear-Site-Data="cache"', '_self');</script>
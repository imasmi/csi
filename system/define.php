<?php
if (isset($_GET["Clear-Site-Data"])) {header('Clear-Site-Data: ' . $_GET["Clear-Site-Data"]);}

require_once(\system\Core::doc_root() . "/system/php/Cookie.php");
require_once(\system\Core::doc_root() . "/system/php/Module.php");
require_once(\system\Core::doc_root() . "/system/php/Data.php");

require_once(\system\Core::doc_root() . "/system/module/Language/php/Language.php");
$Language = new \module\Language\Language;
require_once(\system\Core::doc_root() . "/system/module/User/php/User.php");
$User = new \module\User\User;
require_once(\system\Core::doc_root() . "/system/module/Plugin/php/Plugin.php");
$Plugin = new \module\Plugin\Plugin;
require_once(\system\Core::doc_root() . "/system/module/Theme/php/Theme.php");
$Theme = new \module\Theme\Theme;
if ($Theme->name === false && $User->group("admin") && (\system\Module::_() != "Theme" && \system\Module::_() != "Store")) { ?><script>location.href='<?php echo \system\Core::url();?>Theme/admin/index';</script><?php }
require_once(\system\Core::doc_root() . "/system/module/Page/php/Page.php");
$Page = new \module\Page\Page;

require_once(\system\Core::doc_root() . "/system/module/Text/php/Text.php");
$Text = new \module\Text\Text($Page->id, array("page_id" => 0));
require_once(\system\Core::doc_root() . "/system/module/File/php/File.php");
$File = new \module\File\File($Page->id, array("page_id" => 0));
require_once(\system\Core::doc_root() . "/system/module/Setting/php/Setting.php");
$Setting = new \module\Setting\Setting($Page->id, array("page_id" => 0));

if($User->group("admin")){
    require_once(\system\Core::doc_root() . "/system/module/Text/php/TextAPP.php");
}
?>
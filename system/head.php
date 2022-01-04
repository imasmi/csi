<meta charset="UTF-8">
<meta name="author" content="imaSMI">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="x-ua-compatible" content="IE=edge">
<link rel="stylesheet" href="<?php echo \system\Core::url();?>system/css/WebCss.css">
<?php if($User->group("admin")){ ?>
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>system/css/adminAPP.css">
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>system/module/File/css/FileAPP.css">
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>system/module/Listing/css/ListingAPP.css">
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>system/module/Plugin/css/PluginAPP.css">
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>system/module/System/css/SystemAPP.css">
  <link rel="stylesheet" href="<?php echo \system\Core::url();?>system/module/Text/css/TextAPP.css">
<?php } ?>

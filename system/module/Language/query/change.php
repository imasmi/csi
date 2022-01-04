<?php \system\Cookie::set("language", $_GET["language"]);?>
<script>location.href = '<?php echo \system\Core::url();?>';</script>
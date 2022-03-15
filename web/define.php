<?php
//security check
if($User->id === false && \system\Module::_() != "User"){
?>
<script>location.href='<?php echo \system\Core::url();?>user';</script>
<?php
exit;
}

if($_SERVER["REQUEST_URI"] == "/csi/"){
?>
    <script>location.href='<?php echo \system\Core::url();?>Note/index';</script>
<?php
}

require_once(\system\Core::doc_root() . "/plugin/Font_awesome/php/Font_awesome.php");
$Font_awesome = new \plugin\Font_awesome\Font_awesome(0);

require_once(\system\Core::doc_root() . "/plugin/Caser/php/Caser.php");
$Caser = new \plugin\Caser\Caser;

?>
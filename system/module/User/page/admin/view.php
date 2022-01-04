<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP;
?>
<div class="admin">
<?php $ListingAPP->view($_GET["id"]); ?>
<div class="text-center"><button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button></div>
</div>

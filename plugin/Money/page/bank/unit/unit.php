<div class="csi view">
<?php 
if($User->_() != "admin"){require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");}
$ListingAPP = new \system\module\Listing\php\ListingAPP;
$ListingAPP->_("*","*","bank_units");?>
</div>
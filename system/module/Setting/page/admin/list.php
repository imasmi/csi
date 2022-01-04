<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP;
?>
<div class="admin">
<div class="title">All settings</div>
<?php $ListingAPP->_("*", "*", "module", " ORDER by page_id");?>
</div>

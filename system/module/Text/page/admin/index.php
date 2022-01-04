<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP;
?>
<div class="admin">
<?php
$array = array(
    "id" => "id",
    "location" => array("page_id" => 'if($list["page_id"] == 0){ echo "Global";} else { echo $this->Page->map($list["page_id"]);}'),
    "tag" => "tag",
);

foreach($Language->items as $key => $value){
    $array[$value] = $value;
}
    $ListingAPP->_($array, "*", "module", " ORDER by page_id");
?>
</div>

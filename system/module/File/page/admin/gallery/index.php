<?php
include_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$dir = \system\Core::this_path(0,-1);

$array = array(
    "id" => "id",
    "preview" => array("page_id" => '$File = new \module\File\File($list["page_id"]); echo "<div class=\"file-preview\">" . $File->item($list["id"]) . "</div>";'),
    "page" => array("page_id" => 'echo $this->Page->map($list["page_id"]);'),
    "name" => $Language->_(),
    "tag" => "tag"
);


$actions = array(
    "add" => $dir . "/add",
    "open" => $dir . "/gallery",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>



<div class="admin">
<div class="title">Galleries</div>
<button onclick="location.href='<?php \system\Core::url();?>/File/admin/index'" class="button">Go to files</button>
<?php 
    $ListingAPP = new \module\Listing\ListingAPP; 
    $ListingAPP->_($array, $actions, "module", " WHERE `type` = 'gallery' AND link_id = '0'");
?>
<button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>
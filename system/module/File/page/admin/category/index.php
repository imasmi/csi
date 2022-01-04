<?php
$dir = \system\Core::this_path(0,-1);

$array = array();

foreach($Language->items as $lang => $abbrev){
    $array[$lang] = $abbrev;
}


$actions = array(
    "add" => $dir . "/add?gallery=" . $_GET["gallery"],
    "open" => \system\Core::this_path(0,-2) . "/gallery/gallery",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>



<div class="admin">
<div class="title">Categories</div>
<button onclick="location.href='<?php \system\Core::url();?>/File/admin/gallery/gallery?id=<?php echo $_GET["gallery"];?>'" class="button">Go to gallery</button>
<?php $ListingAPP = new \module\Listing\ListingAPP; $ListingAPP->_($array, $actions, "module", " WHERE `type` = 'gallery' AND link_id = '"  . $_GET["gallery"] . "'");?>
<button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>
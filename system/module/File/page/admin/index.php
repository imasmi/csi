<?php
$dir = $Core->this_path(0,-1);

$array = array(
    "preview" => array("path" => 'echo "<div class=\"file-preview\">" . $this->File->item($list["id"], array("preview" => true)) . "</div>";'),
    "page" => array("page_id" => 'echo $this->Page->map($list["page_id"]);'),
    "Gallery" => array("link_id" => 'if($list["link_id"] != 0){echo "<a href=\"" . $this->Core->this_path(0,-1) . "/gallery/gallery?id=" . $list["link_id"] . "\">" . $this->Query->select($list["link_id"], "id",$this->Query->table("File"), "name")["name"] . "</a>";}'),
    "tag" => "tag",
    "path" => "path",
    "id" => "id"
);

foreach($Language->items as $key=>$value){
    $array[$value] = $value;
}

$actions = array(
    "add" => $dir . "/add",
    "admin" => $dir . "/view",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>

<div class="admin">
    <button onclick="location.href='<?php echo $dir . "/gallery/index";?>'" class="button">Go to galleries</button>
    <?php $ListingAPP = new \system\module\Listing\php\ListingAPP; $ListingAPP->_($array, $actions, "module", "WHERE `type` != 'gallery' ORDER by page_id");?>
    <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>
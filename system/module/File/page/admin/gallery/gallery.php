<?php
include_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$select = $PDO->query("SELECT * FROM " . $File->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
$dir = \system\Core::this_path(0,-2);
$array = array(
    "preview" => array("path" => '$File = new File(' . $select["page_id"] . '); echo "<div class=\"file-preview\">" . $File->item($list["id"], array("preview" => true)) . "</div>";'),
    "row" => "row",
    "category" => array("page_id" => 'global $Language; $select = $this->PDO->query("SELECT * FROM ' . $File->table . ' WHERE id=\'" . $list["page_id"] . "\'")->fetch(); echo $select[$Language->_()];'),
    "path" => "path",
    "id" => "id"
);

foreach($Language->items as $key=>$value){
    $array[$value] = $value;
}

$actions = array(
    "view" => $dir . "/view",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>

<div class="admin">
    <h1 class="text-center"><?php echo $select[$Language->_()];?></h1>
    <button type="button" class="button" onclick="window.open('<?php echo $dir . "/add?gallery=" . $_GET["id"];?>', '_self')"><?php echo ucfirst($Text->item("add files"));?></button>
    <button type="button" class="button" onclick="window.open('<?php echo $dir . "/category/index?gallery=" . $_GET["id"];?>', '_self')"><?php echo ucfirst($Text->item("categories"));?></button>
    <?php 
        $selector = $select["link_id"] == 0 ? "link_id='"  . $_GET["id"] . "'" : "page_id ='"  . $_GET["id"] . "' AND link_id='" . $select["link_id"] . "'";
        $ListingAPP = new \module\Listing\ListingAPP(array("row-order" => "ASC", "row-query" => "link_id='" . $_GET["id"] . "' AND fortable IS NULL"));
        $ListingAPP->_($array, $actions, "module", "SELECT * FROM "  . $File->table . "  WHERE " . $selector . " AND type!='gallery' ORDER by `row` ASC, id ASC");
    ?>
    <div class="text-center"><button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button></div>
</div>
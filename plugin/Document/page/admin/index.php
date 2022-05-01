<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$Object = $Plugin->object();
$dir = \system\Core::this_path(0,-1);
$ListingAPP = new \module\Listing\ListingAPP;

$array = array(
    "name" => "name",
    "type" => ["type" => '$Document = new \plugin\Document\Document; if ($list["type"] != "") {echo $Document->types[$list["type"]];}'],
);

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit",
    //"delete" => \system\Core::url() . "Page/admin/delete"
);
?>

<div class="admin">
    <h2 class="text-center">Документи</h2>
    <a href="<?php echo $dir;?>/template/index" class="button">ШАБЛОНИ</a>
    <select onchange="window.open(this.value, '_self')">
        <option value="<?php echo system\Core::this_path();?>">ВСИЧКИ ДОКУМЕНТИ</option>
        <?php foreach($Object->types as $key => $value) {?>
            <option value="<?php echo $ListingAPP->replace_get(["type" => $key]);?>" <?php if (isset($_GET["type"]) && $_GET["type"] == $key) { echo 'selected';}?>><?php echo $value;?></option>
        <?php } ?>
    </select>
    <?php 
    $type = isset($_GET["type"]) ? "WHERE `type` = '{$_GET["type"]}'" : "";
    $ListingAPP->_($array, $actions, 'doc_types', "$type ORDER by name ASC"); 
    ?>
</div>
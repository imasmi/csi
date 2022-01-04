<?php
$dir = \system\Core::this_path(0,-1);
if(isset($_GET["menu"]) || isset($_GET["link_id"])){
    $link_parts = explode("?", $_SERVER["REQUEST_URI"]);
    $get_link = "?". $link_parts[1];
} else {
    $get_link = "";
}

$actions = array(
    "add" => $dir . "/add" . $get_link,
    "setting" => $dir . "/setting",
    "subpages" => array('', '$check_subpages = $this->PDO->query("SELECT * FROM " . $this->Page->table . " WHERE link_id=\'" . $list["id"] . "\'");
    echo $check_subpages->rowCount() > 0 ? \'<button type="button" class="button" onclick="window.open(\\\'' . \system\Core::this_path() . '?' . (isset($_GET["menu"]) ? 'menu=' . $_GET["menu"] . '&' : '') . 'link_id=\' . $list["id"] . \'\\\', \\\'_self\\\')">Subpages</button>\' : "N/A";'),
    "delete" => $dir . "/delete"
);

$langs = array();
foreach($Language->items as $lang => $abbrev){
    $langs[$lang . " link"] =  $abbrev;
}

$columns = array(
    "tag" => "tag",
    "id" => "id",
    "link_id" => "link_id",
    "row" => "row",
    "menu" => "menu",
    "theme" => array("theme" => 'echo $list["theme"] !== NULL ? $list["theme"] : "N/A";'),
    "plugin" => array("plugin" => 'echo $list["plugin"] !== NULL ? $list["plugin"] : "N/A";'),
    "filename" => "filename",
    "created" => array("created" => 'echo date("d.m.Y H:i:s", strtotime($list["created"]));')
);

$columns = array_merge($langs, $columns);

?>
<div class="admin">
<h1 class="text-center"><?php echo isset($_GET["menu"]) ? "Menu: " . $_GET["menu"] : "Pages";?></h1>
<?php if(!isset($_GET["menu"])){?><button class="button" onclick="window.open('<?php echo \system\Core::this_path(0,-1);?>/menu/index', '_self')">Menus</button><?php } ?>
<?php
$array = isset($_GET["menu"]) ? array("row-query" => "menu='" . $_GET["menu"] . "'", "row-order" => "ASC") : false;
if(isset($_GET["menu"])){
    $link_id = isset($_GET["link_id"]) ? $_GET["link_id"] : $PDO->query("SELECT * FROM " . $Page->table . " WHERE menu='" . $_GET["menu"] . "' ORDER by link_id ASC")->fetch()["link_id"];
    $query_where = " WHERE menu='" . $_GET["menu"] . "' AND link_id='" . $link_id . "' ORDER by `row` ASC, id ASC";
} else {
    if(isset($_GET["link_id"])){
        $query_where = " WHERE link_id='" . $_GET["link_id"] . "' ORDER by id ASC";
    } else {
        $query_where = " WHERE plugin IS null AND link_id=0 ORDER by id ASC";
    }
}
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP($array);
$ListingAPP->_($columns, $actions, "module", $query_where);
?>
</div>

<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
$ListingAPP = new \module\Listing\ListingAPP;
$select = $PDO->query("SELECT * FROM person WHERE id='" . $_GET["person"] . "'")->fetch();

$fields = array(
	"id" => "id",
	"bank" => array("bank_unit" => 'echo $this->PDO->query("SELECT name FROM bank_units WHERE id=\'" . $list["bank_unit"] . "\'")->fetch()["name"];'),
	"IBAN" => "IBAN",
	"budget" => "budget"
);

$dir = \system\Core::this_path(0,-1);
$actions = array(
	"add" => $dir . '/add?person=' . $_GET["person"],
	"edit" => $dir . '/edit',
	"delete" => $dir . '/delete'
);
?>


<div class="admin">
<h4 class="title">Банкови сметки: <?php echo $select["name"];?></h4>
<?php
if($User->group("admin")){require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");}

$where = isset($_GET["person"]) ? "WHERE person_id='" . $_GET["person"] . "'" : "";
echo $ListingAPP->_($fields, $actions, "bank", $where);
?>
</div>
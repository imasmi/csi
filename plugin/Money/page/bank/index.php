<?php
$select = $PDO->query("SELECT * FROM person WHERE id='" . $_GET["person"] . "'")->fetch();

$fields = array(
	"id" => "id",
	"bank" => array("bank_unit" => '$bank = \system\Query::select($list["bank_unit"], "id", "bank_units"); echo $bank["name"];'),
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
<div class="title">Банкови сметки: <?php echo $select["name"];?></div>
<?php
if($User->_() != "admin"){require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");}
$ListingAPP = new \system\module\Listing\php\ListingAPP;
$where = isset($_GET["person"]) ? "WHERE person_id='" . $_GET["person"] . "'" : "";
echo $ListingAPP->_($fields, $actions, "bank", $where);
?>
</div>
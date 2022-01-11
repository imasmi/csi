<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
$ListingAPP = new \module\Listing\ListingAPP;
$dir = \system\Core::this_path(0,-1);

$array = array(
	"" => array("id" => 'echo \'<input class="mass-edit-checkbox" type="checkbox" id="\' . $list["id"] . \'" onclick="csi.massEdit(\\\'#mass-edit\\\')"/>\';'),
	"Дата" => array("date" => 'echo date("d.m.Y", strtotime($list["date"]));'),
	"Вид" => array("type" => 'echo $list["type"] == "bill" ? "Сметка" : "Фактура";'),
	"Сума" => "sum",
	"Дело" => array("case_id" => 'if ($list["case_id"] != 0) {include_once(\system\Core::doc_root() . "/plugin/Caser/php/Caser.php"); $Caser = new \plugin\Caser\Caser($list["case_id"]); $Caser->open();}'),
	"Задължено лице" => array("payer" => 'echo $this->PDO->query("SELECT name FROM person WHERE id=\'" . $list["payer"] . "\'")->fetch()["name"];'),
	"Данъчна основа" => "tax_base",
	"Данък" => "vat",
	"Сметка №" => "bill",
	"Фактура №" => "invoice",
	"Плащания" => array("payment" => 'if($list["payment"] != null){$payments = json_decode($list["payment"]); foreach($payments as $payment_id){ $payment = $this->PDO->query("SELECT * FROM payment WHERE id=\'" . $payment_id . "\'")->fetch(); echo $payment["amount"] . " лева/" . $payment["date"];}}')
);

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit"
);
?>

<div class="admin">
	<button class="button" class="button" onclick="S.all('.mass-edit-checkbox', function(el){ el.click();})">Select all</button>
	<button class="button" class="button" onclick="window.open('<?php echo $dir;?>/edit?id=' + S('#mass-edit').value, '_self')">Mass Edit</button>

	<input type="hidden" id="mass-edit"/>
    <?php
				$where = "";
				if(isset($_GET["end"])){
					$where = " WHERE `date` >= '" . $_GET["start"] . "' AND `date` <= '" . $_GET["end"] . "'";
				} else if(isset($_GET["start"])){
					$where = " WHERE `date` = '" . $_GET["start"] . "'";
				}
        $ListingAPP->_($array, $actions, "invoice", $where . " ORDER by bill DESC");
    ?>
	<button type="button" class="button block center" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>

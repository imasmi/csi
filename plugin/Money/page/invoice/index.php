<?php
$dir = $Core->this_path(0,-1);

$array = array(
	"" => array("id" => 'echo \'<input class="mass-edit-checkbox" type="checkbox" id="\' . $list["id"] . \'" onclick="csi.massEdit(\\\'#mass-edit\\\')"/>\';'),
	"Дата" => array("date" => 'echo date("d.m.Y", strtotime($list["date"]));'),
	"Вид" => array("type" => 'echo $list["type"] == "bill" ? "Сметка" : "Фактура";'),
	"Сума" => "sum",
	"Дело" => array("case_id" => '$Caser = new \plugin\Caser\php\Caser($list["case_id"]); $Caser->open();'),
	"Задължено лице" => array("payer" => '$person = $this->Query->select($list["payer"], "id", "person"); echo $person["name"];'),
	"Данъчна основа" => "tax_base",
	"Данък" => "vat",
	"Сметка №" => "bill",
	"Фактура №" => "invoice",
	"Плащания" => array("payment" => 'if($list["payment"] != null){$payments = json_decode($list["payment"]); foreach($payments as $payment_id){ $payment = $this->Query->select($payment_id, "id", "payment"); echo $payment["amount"] . " лева/" . $payment["date"];}}')
);

$actions = array(
    "add" => $dir . "/add?id=" . $_GET["id"],
    "edit" => $dir . "/edit"
);
?>

<div class="admin">
	<button class="button" class="button" onclick="S.all('.mass-edit-checkbox', function(el){ el.click();})">Select all</button>
	<button class="button" class="button" onclick="window.open('<?php echo $dir;?>/edit?id=' + S('#mass-edit').value, '_self')">Mass Edit</button>

	<input type="hidden" id="mass-edit"/>
    <?php
				$where = "";
        $ListingAPP = new \system\module\Listing\php\ListingAPP;
				if(isset($_GET["end"])){
					$where = " WHERE `date` >= '" . $_GET["start"] . "' AND `date` <= '" . $_GET["end"] . "'";
				} else if(isset($_GET["start"])){
					$where = " WHERE `date` = '" . $_GET["start"] . "'";
				}
        $ListingAPP->_($array, $actions, "invoice", $where . " ORDER by bill DESC");
    ?>
	<button type="button" class="button block center" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>

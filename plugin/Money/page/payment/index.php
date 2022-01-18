<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
$ListingAPP = new \module\Listing\ListingAPP;
$dir = \system\Core::this_path(0,-1);

$array = array(
	"Дата" => array("date" => 'echo date("d.m.Y", strtotime($list["date"]));'),
	"Сума" => "amount",
	"Дело" => array("case_id" => 'include_once(\system\Core::doc_root() . "/plugin/Caser/php/Caser.php"); $Caser = new \plugin\Caser\Caser($list["case_id"]); $Caser->open();'),
	"Основание" => "reason",
	"Бордеро" => "number",
	"Платец" => array("person" => 'echo $this->PDO->query("SELECT name FROM person WHERE id=\'" . $list["person"] . "\'")->fetch()["name"];'),
	"Банка" => array("bank"=>  'echo $this->PDO->query("SELECT IBAN FROM bank WHERE id=\'" . $list["bank"] . "\'")->fetch()["IBAN"];'),
	"За разпределяне" => array("allocate" => 'echo $list["allocate"] > 0 ? $list["allocate"] : "Не";'),
	"Разпределени" => array("partitioned" => 'echo $list["allocate"] > 0 ? $list["partitioned"] : "";'),
	"Неразпределени" => array("unpartitioned" => 'echo $list["allocate"] > 0 ? $list["unpartitioned"] : "";'),
	"Бележка" => "note",
	"Сметка/фактура" => array("id" => 'foreach($this->PDO->query("SELECT bill, invoice FROM invoice WHERE payment LIKE \'%" . $list["id"] . "%\'") as $invoice){ echo $invoice["bill"] . "/" . $invoice["invoice"] . "<br>";}')

);

$actions = array(
    "add" => $dir . "/add",
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>

<div class="admin">
	<div class="inline-block">
	<select onchange="if(this.value){window.open(this.value, '_self');}">
		<option value="">Банкова сметка</option>
		<?php foreach($PDO->query("SELECT * FROM bank WHERE person_id=1") as $bank){?>
			<option value="<?php echo \system\Core::url() . $ListingAPP->replace_get(array("bank" => $bank["id"], "p" => 1));?>" <?php if(isset($_GET["bank"]) && $_GET["bank"] == $bank["id"]){ echo 'selected';}?>><?php echo $bank["IBAN"];?></option>
		<?php } ?>
	</select>
	<?php 
	$get = $_GET;
	unset($get["url"]);
	?>
	<a class="button" href="<?php echo \system\Core::this_path(0, -1) . '/print?' . http_build_query($get);?>">Печат</a>
	</div>
    <?php 
		$period = isset($_GET["end"]) && $_GET["end"] != "" ? " WHERE date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " WHERE date >= '" . $_GET["start"] . "'" : null);
        $bank = isset($_GET["bank"]) ? ($period ? " AND bank='" . $_GET["bank"] . "'" : " WHERE bank='" . $_GET["bank"] . "'") : null;
		$ListingAPP->_($array, $actions, "payment", $period . $bank.  " ORDER by date DESC, `datetime` DESC");
    ?>
	<button type="button" class="button block center" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>
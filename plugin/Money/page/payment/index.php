<?php
$dir = $Core->this_path(0,-1);

$array = array(
	"Дата" => array("date" => 'echo date("d.m.Y", strtotime($list["date"]));'),
	"Сума" => "amount",
	"Дело" => array("case_id" => '$Caser = new \plugin\Caser\php\Caser($list["case_id"]); $Caser->open();'),
	"Основание" => "reason",
	"Бордеро" => "bordero",
	"Платец" => array("person" => '$person = $this->Query->select($list["person"], "id", "person"); echo $person["name"];'),
	"Банка" => array("bank"=>  '$bank = $this->Query->select($list["bank"], "id", "bank"); echo $bank["IBAN"];'),
	"За разпределяне" => array("allocate" => 'echo $list["allocate"] > 0 ? $list["allocate"] : "Не";'),
	"Разпределени" => array("partitioned" => 'echo $list["allocate"] > 0 ? $list["partitioned"] : "";'),
	"Неразпределени" => array("unpartitioned" => 'echo $list["allocate"] > 0 ? $list["unpartitioned"] : "";'),
	"Бележка" => "note",
	"Сметка/фактура" => array("id" => 'foreach($this->PDO->query("SELECT bill, invoice FROM invoice WHERE payment LIKE \'%" . $list["id"] . "%\'") as $invoice){ echo $invoice["bill"] . "/" . $invoice["invoice"] . "<br>";}')

);

$actions = array(
    "add" => $dir . "/add?id=" . $_GET["id"],
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);


$ListingAPP = new \system\module\Listing\php\ListingAPP;
?>

<div class="admin">
	<div class="inline-block">
	<select onchange="if(this.value){window.open(this.value, '_self');}">
		<option value="">Банкова сметка</option>
		<?php foreach($PDO->query("SELECT * FROM bank WHERE person_id=1") as $bank){?>
			<option value="<?php echo $Core->get_extend(array("bank" => $bank["id"], "p" => 1));?>" <?php if(isset($_GET["bank"]) && $_GET["bank"] == $bank["id"]){ echo 'selected';}?>><?php echo $bank["IBAN"];?></option>
		<?php } ?>
	</select>
	</div>
    <?php 
		$period = isset($_GET["end"]) && $_GET["end"] != "" ? " WHERE date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " WHERE date >= '" . $_GET["start"] . "'" : null);
        $bank = isset($_GET["bank"]) ? ($period ? " AND bank='" . $_GET["bank"] . "'" : " WHERE bank='" . $_GET["bank"] . "'") : null;
		$ListingAPP->_($array, $actions, "payment", $period . $bank.  " ORDER by date DESC, transaction_date DESC");
    ?>
	<button type="button" class="button block center" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>
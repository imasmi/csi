<?php
namespace plugin\Money;
use \module\Setting\Setting as Setting;
use \plugin\Caser\Caser as Caser;

class Money{
	public function __construct($case_id=false){
		global $PDO;
		$this->PDO = $PDO;
		global $Page;
		$this->Page = $Page;
		global $User;
		$this->User = $User;
		global $Setting;
		$this->Setting = $Setting;
		$this->case_id = $case_id;
		$this->plugin = "Money";
	}
	
	public function sum($sum){
		return number_format($sum, 2, ".", " ");
	}
	//["sum" => int, "start" => string(date), "end" => string(date)]
	public static function interest($data) {
		$now = isset($data["end"]) ? strtotime($data["end"]) : time();
		$your_date = strtotime($data["start"]);
		$datediff = ($now - $your_date)/ (60 * 60 * 24) + 1;
		return number_format((($data["sum"]/10)/365.25) * $datediff, 2);
	}
	
	public function payment(){
	?>
		<div class="csi view">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th>Дата</th>
					<th>Дело</th>
					<th>Добавил</th>
					<th>Причина</th>
					<th>Длъжник</th>
					<th>Сума</th>
					<th>За разпределяне</th>
					<th>Разпределени</th>
					<th>Неразпределени</th>
					<th>Сметка/фактура</th>
				</tr>
				
				<?php
				$payments = array();
				$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : " AND date>='" . date("Y-m-d", strtotime(" -7 days")) . "'");
				$case_id = isset($this->case_id) ? " AND case_id='" . $this->case_id . "'" : "";
				$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
				foreach($this->PDO->query("SELECT * FROM payment WHERE amount > 0 " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, id DESC") as $payment){
					$Caser = new Caser($payment["case_id"]);
					if($charger !== false){
						if($_GET["charger"] == $Caser->charger){$payments[] = $payment;}
					} else {
						if($this->User->group("пчси") || $this->User->group("деловодител")){ 
							if($this->User->id == $Caser->charger){$payments[] = $payment;}
						} else {
							$payments[] = $payment;
						}
					}
				}
				foreach(( $this->case_id ? $payments : $this->ListingAPP->page_slice($payments) ) as $payment){
				$Caser = new Caser($payment["case_id"]);
				$paymentDate = date("d.m.Y", strtotime($payment["date"]));
				?>
				<tr>
					<td><?php echo  $paymentDate;?></td>
					<td><a href="" class="caseNumber"><?php echo $Caser->number;?></a></td>
					<td><?php echo  $this->User->item($payment["user"])["email"];?></td></td>
					<td><?php //echo $this->PDO->query("SELECT name FROM doc_types WHERE id='" . $payment["name"] . "'")->fetch()["name"];?></td>
					<td><?php echo $payment["reason"];?></td>
					<td><?php echo $this->sum($payment["amount"]);?></td>
					<td><?php echo $payment["allocate"] > 0 ? $this->sum($payment["allocate"]) : "Не се разпределя";?></td>
					<td><?php echo $payment["allocate"] > 0 ? $this->sum($payment["partitioned"]) : "Не се разпределя";?></td>
					<td><?php echo $payment["allocate"] > 0 ? $this->sum($payment["unpartitioned"]) : "Не се разпределя";?></td>
					<td>
						<?php 
						foreach($this->PDO->query("SELECT bill, invoice FROM invoice WHERE payment LIKE '%" . $payment["id"] . "%'") as $invoice){ 
							echo $invoice["bill"] . "/" . $invoice["invoice"] . "<br>";
						}
						?>
					</td>
				</tr>
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($payments));}?>
		</div>
	<?php
	}
	
	public function invoice(){
		$array = array(
			"Дата" => array("date", 'echo date("d.m.Y", strtotime($list["date"]));'),
			"Вид" => array("type", 'echo $list["type"] == "bill" ? "Сметка" : "Фактура";'),
			"Сума" => "sum",
			"Дело" => array("case_id", '$caser = \system\Database::select($list["case_id"], "id", "caser"); echo $caser["number"];'),
			"Задължено лице" => array("payer", '$person = \system\Database::select($list["payer"], "id", "person"); echo $person["name"];'),
			"Данъчна основа" => "tax_base",
			"Данък" => "vat",
			"Сметка №" => "bill",
			"Фактура №" => "invoice",
		);
		$dir = \system\Core::url() . "Money/invoice";
		$actions = array(
			"add" => $dir . "/add?id=" . $_GET["id"],
			"edit" => $dir . "/edit",
			"delete" => $dir . "/delete"
		);
	?>
		<div class="csi view">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th>Дата</th>
					<th>Вид</th>
					<th>Сума</th>
					<th>Дело</th>
					<th>Задължено лице</th>
					<th>Данъчна основа</th>
					<th>Данък</th>
					<th>Сметка №</th>
					<th>Фактура №</th>
					<th></th>
				</tr>
				
				<?php
				$invoice = array();
				foreach($this->PDO->query("SELECT * FROM invoice WHERE case_id='" . $this->case_id . "' ORDER by date DESC, id DESC") as $invoice){
				$Caser = new Caser($invoice["case_id"]);
				$invoiceDate = date("d.m.Y", strtotime($invoice["date"]));
				?>
				<tr>
					<td><?php echo  $invoiceDate;?></td>
					<td><?php echo  $invoice["type"] == "bill" ? "Сметка" : "фактура";?></td>
					<td><?php echo $this->sum($invoice["sum"]);?></td>
					<td><a href="" class="caseNumber"><?php echo $Caser->number;?></a></td>
					<td><?php echo \system\Database::select($invoice["payer"], "id", "person")["name"];?></td></td>
					<td><?php echo $this->sum($invoice["tax_base"]);?></td>
					<td><?php echo $this->sum($invoice["vat"]);?></td>
					<td><?php echo $invoice["bill"];?></td>
					<td><?php echo $invoice["invoice"];?></td>
					<td><button type="button" class="button" onclick="window.open('<?php echo \system\Core::url();?>Money/invoice/edit?id=<?php echo $invoice["id"];?>', '_self')">Редакция</button></td>
				</tr>
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($payments));}?>
		</div>
	<?php
	}
}
?>

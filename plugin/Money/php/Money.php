<?php
namespace plugin\Money;
use \module\Setting\Setting as Setting;
use \plugin\Caser\Caser as Caser;

class Money{
	public function __construct($case_id=false, $data = []){
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
		if ($this->case_id != false) {
			$this->total = ["debt" => ["sum" => 0], "tax" => ["sum" => 0]];
			$this->date = isset($this->data["date"]) ? $this->data["date"] : date("Y-m-d");
			$this->debts = $this->debts();
			$this->taxes = $this->taxes();
		}
	}
	
	public static function sum($sum){
		return number_format($sum, 2, ".", " ");
	}
	
	//["sum" => int, "start" => string(date), "end" => string(date)]
	public static function interest($data) {
		$now = isset($data["end"]) ? strtotime($data["end"]) : strtotime(date("Y-m-d"));
		$your_date = strtotime($data["start"]);
		$datediff = ($now - $your_date)/ (60 * 60 * 24);
		return number_format((($data["sum"]/10)/360) * $datediff, 2);
	}

    public static function debt_types () {
        $types = [];
        foreach($GLOBALS["PDO"]->query("SELECT * FROM " . $GLOBALS["Setting"]->table . " WHERE fortable='debt'", \PDO::FETCH_ASSOC) as $setting){
            $types[$setting["id"]] = $setting;
        }
        return $types;
    }

    public static function tax ($sum) {
        $total = 0;
        if ($sum > 100000) {
            $total = 5220 + ((($sum - 100000)/100) * 2);
        } else if ($sum > 50000) {
            $total = 3220 + ((($sum - 50000)/100) * 4);
        } else if ($sum > 10000) {
            $total = 820 + ((($sum - 10000)/100) * 6);
        } else if ($sum > 1000) {
            $total = 100 + ((($sum - 1000)/100) * 8);
        } else {
            $total = $sum / 10;
        }
        return number_format($total, 2);
    }
	
	public function debts(){
		$debts = [];
		foreach($this->PDO->query("SELECT * FROM debt WHERE case_id='" . $this->case_id . "'", \PDO::FETCH_ASSOC) as $debt){
			$debts[$debt["id"]] = $debt;
			$debts[$debt["id"]]["debt"] = ["sum" => 0];
			$debts[$debt["id"]]["items"] = [];
			foreach($this->PDO->query("SELECT * FROM debt_item WHERE debt_id='" . $debt["id"] . "'", \PDO::FETCH_ASSOC) as $debt_item){
                if ( $debt_item["link_id"] == 0 ) {
                    $debt_item["type"] = $debt_item["setting_id"] == 110 ? "interest" : "non-interest";
                    $debts[$debt["id"]]["items"][$debt_item["id"]] = $debt_item;
					$debts[$debt["id"]]["debt"]["sum"] += $debt_item["sum"];
					$this->total["debt"]["sum"] += $debt_item["sum"];
                } else if ($debt_item["date"] <= $this->date) {
                    $debt_item["amount"] = static::interest(["sum" => $debt_item["sum"], "start" => $debt_item["date"], "end" => $this->date]);
                    $debts[$debt["id"]]["items"][$debt_item["link_id"]]["interest"][$debt_item["id"]] = $debt_item;
					$debts[$debt["id"]]["debt"]["sum"]  += static::interest(["sum" => $debt_item["sum"], "start" => $debt_item["date"], "end" => $this->date]);
					$this->total["debt"]["sum"] += static::interest(["sum" => $debt_item["sum"], "start" => $debt_item["date"], "end" => $this->date]);
				}
            }

			$total_tax = static::tax($debts[$debt["id"]]["debt"]["sum"]);
			$debts[$debt["id"]]["tax"]["sum"] = $total_tax;
			foreach($debts[$debt["id"]]["items"] as $id => $item){
				$debts[$debt["id"]]["items"][$id]["tax"] = number_format(($item["sum"] / $debts[$debt["id"]]["debt"]["sum"]) * $total_tax, 2);
				if ($item["type"] == "interest") {
					foreach ( $item["interest"] as $interest) {
						$debts[$debt["id"]]["items"][$id]["interest"][$interest["id"]]["tax"] = number_format(($interest["amount"] / $debts[$debt["id"]]["debt"]["sum"]) * $total_tax, 2);
					}
				}
			}
		}
		return $debts;
	}

	public function taxes(){
		foreach ($this->PDO->query("SELECT * FROM tax WHERE case_id='" . $this->case_id . "' ORDER by date DESC", \PDO::FETCH_ASSOC) as $tax) {
			$taxes[$tax["id"]] = $tax;
			$this->total["tax"]["sum"] += $tax["sum"];
		}
		return $taxes;
	}

	public function payment(){
	?>
		<form method="post" action="<?php echo \system\Core::url();?>Money/distribution/add" class="admin">
			<input type="hidden" name="case_id" value="<?php echo $this->case_id;?>">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th><a href="<?php echo \system\Core::url();?>Money/payment/add?case_id=<?php echo $this->case_id;?>" class="button"><?php echo $GLOBALS["Font_awesome"]->_("Add icon");?></a></th>
					<th></th>
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
				$total = [];
				foreach(( $this->case_id ? $payments : $this->ListingAPP->page_slice($payments) ) as $payment){
				$Caser = new Caser($payment["case_id"]);
				$paymentDate = date("d.m.Y", strtotime($payment["date"]));
				?>
				<tr>
					<td><a href="<?php echo \system\Core::url();?>Money/payment/edit?id=<?php echo $payment["id"];?>" class="button button-icon"><?php echo $GLOBALS["Font_awesome"]->_("Edit icon");?></a></td>
					<td><input name="payment_<?php echo $payment["id"];?>" type="checkbox" onclick="<?php foreach (["amount", "allocate", "partitioned", "unpartitioned"] as $sum_id){?> csi.totalSum(this,'#selected-<?php echo $sum_id;?>','<?php echo $payment[$sum_id];?>'); <?php } ?>"></td>
					<td><?php echo  $paymentDate;?></td>
					<td><a href="" class="caseNumber"><?php echo $Caser->number;?></a></td>
					<td><?php echo  $this->User->item($payment["user"])["email"];?></td></td>
					<td><?php echo $payment["reason"];?></td>
					<td>
						<?php 
							foreach(json_decode($payment["debtor"], true) as $debtor_id) {
							?>
							<div><?php echo $this->PDO->query("SELECT name FROM person WHERE id='" . $debtor_id . "'")->fetch()["name"];?></div>
							<?php
							}
						?>
					</td>
					<td>
						<?php 
							echo $this->sum($payment["amount"]);
							$total["amount"] = isset($total["amount"]) ? $total["amount"] += $payment["amount"] : $payment["amount"];
						?>
					</td>
					<td>
						<?php 
						echo $payment["allocate"] > 0 ? $this->sum($payment["allocate"]) : "Не се разпределя";
						$total["allocate"] = isset($total["allocate"]) ? $total["allocate"] += $payment["allocate"] : $payment["allocate"];
						?>
					</td>
					<td>
						<?php 
						echo $payment["allocate"] > 0 ? $this->sum($payment["partitioned"]) : "Не се разпределя";
						$total["partitioned"] = isset($total["partitioned"]) ? $total["partitioned"] += $payment["partitioned"] : $payment["partitioned"];
						?>
					</td>
					<td>
						<?php 
							echo $payment["allocate"] > 0 ? $this->sum($payment["unpartitioned"]) : "Не се разпределя";
							$total["unpartitioned"] = isset($total["unpartitioned"]) ? $total["unpartitioned"] += $payment["unpartitioned"] : $payment["unpartitioned"];
						?>
					</td>
					<td>
						<?php 
						foreach($this->PDO->query("SELECT bill, invoice FROM invoice WHERE payment LIKE '%" . $payment["id"] . "%'") as $invoice){ 
							echo $invoice["bill"] . "/" . $invoice["invoice"] . "<br>";
						}
						?>
					</td>
				</tr>
				<?php } ?>

				<?php if (!empty($total)) { ?>
				<tr>
					<th>Избрани</th>
					<th colspan="2"><button type="submit" class="button">Разпредели</button></th>
					<th colspan="4"></th>
					<th id="selected-amount"><?php echo static::sum(0);?></th>
					<th id="selected-allocate"><?php echo static::sum(0);?></th>
					<th id="selected-partitioned"><?php echo static::sum(0);?></th>
					<th id="selected-unpartitioned"><?php echo static::sum(0);?></th>
					<th colspan="5"></th>
				</tr>

				<tr>
					<th>Общо</th>
					<th colspan="6"></th>
					<th><?php echo static::sum($total["amount"]);?></th>
					<th><?php echo static::sum($total["allocate"]);?></th>
					<th><?php echo static::sum($total["partitioned"]);?></th>
					<th><?php echo static::sum($total["unpartitioned"]);?></th>
					<th></th>
				</tr>
				<?php } ?>

			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($payments));}?>
		</form>
	<?php
	}
	
	public function invoice(){
		$array = array(
			"Дата" => array("date", 'echo date("d.m.Y", strtotime($list["date"]));'),
			"Вид" => array("type", 'echo $list["type"] == "bill" ? "Сметка" : "Фактура";'),
			"Сума" => "sum",
			"Дело" => array("case_id", 'echo $this->PDO->query("SELECT number FROM caser WHERE id=$list["case_id"]")->fetch()["number"];'),
			"Задължено лице" => array("payer", 'echo $this->PDO->query("SELECT name FROM person WHERE id=$list["payer"]")->fetch()["name"];'),
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
		<div class="admin">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th><a href="<?php echo \system\Core::url();?>Money/invoice/add?case_id=<?php echo $this->case_id;?>" class="button"><?php echo $GLOBALS["Font_awesome"]->_("Add icon");?></a></th>
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
					<td><a href="<?php echo \system\Core::url();?>Money/invoice/edit?id=<?php echo $invoice["id"];?>" class="button button-icon"><?php echo $GLOBALS["Font_awesome"]->_("Edit icon");?></a></td>
					<td><?php echo  $invoiceDate;?></td>
					<td><?php echo  $invoice["type"] == "bill" ? "Сметка" : "фактура";?></td>
					<td><?php echo $this->sum($invoice["sum"]);?></td>
					<td><a href="" class="caseNumber"><?php echo $Caser->number;?></a></td>
					<td><?php echo $this->PDO->query("SELECT name FROM person WHERE id='" . $invoice["payer"] . "'")->fetch()["name"];?></td></td>
					<td><?php echo $this->sum($invoice["tax_base"]);?></td>
					<td><?php echo $this->sum($invoice["vat"]);?></td>
					<td><?php echo $invoice["bill"];?></td>
					<td><?php echo $invoice["invoice"];?></td>
				</tr>
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($payments));}?>
		</div>
	<?php
	}
}
?>

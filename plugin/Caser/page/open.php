<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Title.php');
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
include_once(\system\Core::doc_root() . '/plugin/Document/php/Document.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Money.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/web/php/dates.php');
use \plugin\Money\Money;
$Caser = new \plugin\Caser\Caser($_GET["id"]);
$charger = $PDO->query("SELECT * FROM " . $User->table . " WHERE id='" . $Caser->charger . "'")->fetch();
$Reference = new \plugin\Reference\Reference;
$Document = new \plugin\Document\Document($_GET["id"]);
$date = isset($_GET["debt_date"]) ? $_GET["debt_date"] : date("Y-m-d");
$Money = new \plugin\Money\Money($_GET["id"], ["date" => $date]);
$debt_types = Money::debt_types();

?>
<div id="caser">
	<div class="clear">
		<div class="column-3 padding-40 text-center">
			<h3 class="<?php echo $Caser->color;?>"><?php echo $Caser->number;?></h3>
			<div>Статус: <?php echo $Caser->status;?></div>
			<div>Отговорник: <?php echo $Caser->charger;?></div>
			<div>Ред статистика: <?php echo $Caser->statistic;?></div>
			<a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/edit?id=<?php echo $_GET["id"];?>"><?php echo $Font_awesome->_("Edit icon");?></a>
		</div>

		<div class="column-9 admin paddingY-40">
			<?php \plugin\Note\Note::listing(" WHERE case_id='" . $_GET["id"] . "' AND hide is NULL ORDER by period DESC, id DESC", $_GET["id"]);?>
		</div>
	</div>
	
	<div id="title" class="text-center clear padding-bottom-100">
		<div class="margin-20"><h3 class="inline-block margin-0">Титули</h3> <a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/add?id=<?php echo $_GET["id"];?>"><?php echo $Font_awesome->_("Add icon");?></a></div>
		<div>
			Банка по делото: 
			<?php 
				echo $PDO->query("SELECT IBAN FROM bank b LEFT JOIN caser c ON b.id = c.prefBANK WHERE c.id ='" . $_GET["id"] . "'")->fetch()["IBAN"];
			?>
		</div>
		<?php foreach($Caser->title as $title){
			$Title = new \plugin\Caser\Title($title["id"]);
			?>
			<div class="caser-title clear">
				<div class="column-6 clear text-center">
					<?php $Title->data(); ?>
				</div>
				
				<div class="column-6 padding-10 text-center">
					<div class="column-6">
						<div class="title margin-bottom-20"><h4 class="inline-block margin-0">Взискатели</h4> <a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/add-person?id=<?php echo $title["id"];?>&type=creditor"><?php echo $Font_awesome->_("Add icon");?></a></div>
						<div class="marginY-20"></div>
						<?php $Title->creditors(); ?>
					</div>
					
					<div class="column-6">
						<div class="title margin-bottom-20"><h4 class="inline-block margin-0">Длъжници</h4> <a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/add-person?id=<?php echo $title["id"];?>&type=debtor"><?php echo $Font_awesome->_("Add icon");?></a></div>
						<?php $Title->debtors();?>
					</div>
				</div>
			</div>
		<?php } ?>

		<h2>ДЪЛГ към <?php echo \web\dates::_($date);?></h2>
			<table class="center">
				<tr>
					<th></th>
					<th>Общо</th>
					<th>Платени</th>
					<th>Остатък</th>
				</tr>
				<tr>
					<th>За взискатели</th>
					<td><?php echo $Money->total["sum"];?></td>
					<td><?php echo $Money->total["paid"];?></td>
					<td class="color-1-bg"><?php echo $Money->total["unpaid"];?></td>
				</tr>
				<tr>
					<th>За такси</th>
					<td><?php echo $Money->total["tax"];?></td>
					<td><?php echo $Money->total["tax-paid"];?></td>
					<td class="color-1-bg"><?php echo $Money->total["tax-unpaid"];?></td>
				</tr>
				<tr>
					<th>Общо дълг</th>
					<td><?php echo $Money->total["sum"] + $Money->total["tax"];?></td>
					<td><?php echo $Money->total["paid"] + $Money->total["tax-paid"];?></td>
					<td class="color-1-bg"><?php echo $Money->total["unpaid"] + $Money->total["tax-unpaid"];?></td>
				</tr>

			</table>

			<div class="column-6 padding-10">
				<h3>Такси</h3>
				<form action="<?php echo \system\Core::url();?>Money/invoice/add?case_id=<?php echo $_GET["id"];?>" method="post">
					<table cellpadding="5" cellspacing="0" class="border-bottom-row">
						<tr>
							<th><a class="button button-icon" href="<?php echo \system\Core::url();?>Money/tax/add?case_id=<?php echo $_GET["id"];?>&title_id=<?php echo $title["id"];?>" title="Добавяне на такса"><?php echo $GLOBALS["Font_awesome"]->_("Add icon");?></a></th>
							<th><button class="button">Фактура</button></th>
							<th>Точка</th>
							<th>Брой</th>
							<th>Дата</th>
							<th>Бележка</th>
							<th>Предплатил</th>
							<th>Длъжници</th>
							<th>Сума</th>
							<th>Платени</th>
							<th>Остатък</th>
						</tr>
						<?php 
						$total_taxes = ["sum" => 0, "paid" => 0, "unpaid" => 0];
						foreach ($Money->taxes as $tax) { ?>
						<tr>
							<td><a class="button button-icon" href="<?php echo \system\Core::url();?>/Money/tax/edit?id=<?php echo $tax["id"];?>"><?php echo $Font_awesome->_("Edit icon");?></a></td>
							<td><input type="checkbox" name="tax_<?php echo $tax["id"];?>" onclick="csi.totalSum(this,'#selected-taxes','<?php echo $tax['count'];?>'); csi.totalSum(this,'#selected-sums','<?php echo $tax['sum'];?>')"></td>
							<td>т.<?php echo $tax["point_number"];?></td>
							<td><?php echo $tax["count"];?></td>
							<td><?php echo web\dates::_($tax["date"]);?></td>
							<td><?php echo $tax["note"];?></td>
							<td>
								<?php 
									if($tax["prepaid"] == 1) {
										$payer = $PDO->query("SELECT payer FROM invoice WHERE tax LIKE '%\"" . $tax["id"] . "\":%'")->fetch()["payer"];
										echo $PDO->query("SELECT name FROM person WHERE id='$payer'")->fetch()["name"];
									}
								?>
							</td>
							<td>
								<?php 
									if ($tax["debtor"] != null) {
										foreach(json_decode($tax["debtor"], true) as $debtor_id){
											?>
											<div><?php echo $PDO->query("SELECT name FROM person WHERE id='" . $debtor_id . "'")->fetch()["name"];?></div>
											<?php
										}
									}
								?>
							</td>
							<td><?php echo $tax["sum"]; $total_taxes["sum"] += $tax["sum"];?></td>
							<td><?php echo Money::sum($tax["paid"]);  $total_taxes["paid"] += $tax["paid"];?></td>
							<td><?php echo Money::sum($tax["unpaid"]); $total_taxes["unpaid"] += $tax["unpaid"];?></td>
						</tr>
						<?php } ?>
						
						<tr>
							<th>Избрани</th>
							<th colspan="2"></th>
							<th id="selected-taxes">0</th>
							<th colspan="3"></th>
							<th id="selected-sums"><?php echo \plugin\Money\Money::sum(0);?></th>
							<th></th>
							<th></th>
						</tr>

						<tr>
							<th>Общо</th>
							<th colspan="2"></th>
							<th><?php echo count($Money->taxes);?></th>
							<th colspan="3"></th>
							<th><?php echo \plugin\Money\Money::sum($total_taxes["sum"]);?></th>
							<th><?php echo \plugin\Money\Money::sum($total_taxes["paid"]);?></th>
							<th><?php echo \plugin\Money\Money::sum($total_taxes["unpaid"]);?></th>
						</tr>
					</table>
				</form>
			</div>

			<div class="column-6">
				<div class="margin-bottom-20">
					<h3 class="inline-block marginY-0">Дълг</h3>
					<a class="button button-icon" href="<?php echo \system\Core::url();?>Money/debt/add?caser_id=<?php echo $_GET["id"];?>&title_id=<?php echo $title["id"];?>" title="Добавяне на дълг"><?php echo $GLOBALS["Font_awesome"]->_("Add icon");?></a>
				</div>

				<?php  foreach ($Money->debts as $debt) { ?>
					<div class="color-4-bg">Длъжници: <?php echo \plugin\Person\Person::list(json_decode($debt["debtor"], true));?></div>

					<table cellpadding="5" cellspacing="0" class="border-bottom-row">
						<tr>
							<th><a class="button button-icon" href="<?php echo \system\Core::url();?>/Money/debt/edit?id=<?php echo $debt["id"];?>"><?php echo $Font_awesome->_("Edit icon");?></a></th>
							<th>#</th>
							<th>Вид</th>
							<th>Сума</th>
							<th>т.26</th>
							<th>Неплатена</th>
							<th>Неплатена т.26</th>
						</tr>
						<?php 
						$cnt = 0;
						$total_debt = 0;
						foreach ($debt["items"] as $debt_item) { 
							?>
							<tr>
								<td><input type="checkbox" onclick="csi.totalSum(this,'#selected-debts','<?php echo $debt_item["sum"];?>');"></td>
								<td><?php echo ++$cnt;?></td>
								<td><?php echo $debt_types[$debt_item["setting_id"]]["type"];?>, <?php echo $debt_types[$debt_item["subsetting_id"]]["type"];?></td>
								<td><?php echo $debt_item["sum"];?></td>
								<td><?php echo $debt_item["tax"];?></td>
								<td><?php echo $debt_item["unpaid"];?></td>
								<td><?php echo $debt_item["tax-unpaid"];?></td>
							</tr>
							<?php 
							if ($debt_item["type"] == "interest") {
								$sub_cnt = 0;
								foreach ($debt_item["interest"] as $interest) { 
									?>
								<tr>
									<td><input type="checkbox" onclick="csi.totalSum(this,'#selected-debts','<?php echo $interest["amount"];?>');"></td>
									<td></td>
									<td><?php echo $cnt . '.' . ++$sub_cnt;?>) Законна лихва върху <?php echo $interest["sum"];?> лева от <?php echo web\dates::_($interest["date"]);?> до <?php echo web\dates::_($Money->date);?></td>
									<td><?php echo $interest["amount"];?></td>
									<td><?php echo $interest["tax"];?></td>
									<td><?php echo $interest["unpaid"];?></td>
									<td><?php echo $interest["tax-unpaid"];?></td>
								</tr>
								<?php
								}
							}
						} ?>

						<tr>
							<th>Избрани</th>
							<th colspan="2"></th>
							<th id="selected-debts"><?php echo \plugin\Money\Money::sum(0);?></th>
							<td colspan="3"></td>
						</tr>

						<tr>
							<th>Общо</th>
							<th colspan="2"></th>
							<th><?php echo \plugin\Money\Money::sum($debt["sum"]);?></th>
							<th><?php echo \plugin\Money\Money::sum($debt["tax"]);?></th>
							<th><?php echo \plugin\Money\Money::sum($debt["unpaid"]);?></th>
							<th><?php echo \plugin\Money\Money::sum($debt["tax-unpaid"]);?></th>
						</tr>

					</table>
				<?php } ?>
			</div>
	</div>
	
	<section id="incoming">
		<h3 class="tag" onclick="csi.section('#caser #incoming')">Входящи документи</h3>
		<?php $Document->incoming();?>
	</section>
	
	<section id="outgoing">
		<h3 class="tag" onclick="csi.section('#caser #outgoing')">Изходящи документи</h3>
		<?php $Document->outgoing();?>
	</section>
	
	<section id="protocol">
		<h3 class="tag" onclick="csi.section('#caser #protocol')">Протоколи</h3>
		<?php $Document->protocol();?>
	</section>
	
	<section id="payment">
		<h3 class="tag" onclick="csi.section('#caser #payment')">Плащания</h3>
		<?php $Money->payment();?>
	</section>
	
	<section id="distribution">
		<h3 class="tag" onclick="csi.section('#caser #distribution')">Разпределения</h3>
	</section>
	
	<section id="invoice">
		<h3 class="tag" onclick="csi.section('#caser #invoice')">Фактури</h3>
		<?php $Money->invoice();?>
	</section>
</div>

<script>
window.addEventListener('load',function(){
	if(location.hash){csi.section('#caser ' + location.hash);}
});
</script>
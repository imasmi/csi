<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Title.php');
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
include_once(\system\Core::doc_root() . '/plugin/Document/php/Document.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Money.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/web/php/dates.php');

function total($total, $tax, $name) {
	return isset($total[$name]) ? $total[$name] += $tax[$name] : $tax[$name];
}

$Caser = new \plugin\Caser\Caser($_GET["id"]);
$charger = $PDO->query("SELECT * FROM " . $User->table . " WHERE id='" . $Caser->charger . "'")->fetch();
$Reference = new \plugin\Reference\Reference;
$Document = new \plugin\Document\Document($_GET["id"]);
$Money = new \plugin\Money\Money($_GET["id"]);
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
	
	<div id="title" class="text-center">
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
				<div class="column-3 clear text-center">
					<?php $Title->data(); ?>
				</div>
				
				<div class="column-4 padding-10 text-center">
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

				<div class="column-5 padding-10">

					<h3>Такси</h3>
					<table cellpadding="5" cellspacing="0" class="border-bottom-row">
						<tr>
							<th></th>
							<th></th>
							<th>Точка</th>
							<th>Брой</th>
							<th>Сума</th>
							<th>Дата</th>
							<th>Бележка</th>
							<th>Длъжници</th>
						</tr>
						<?php 
						$total_taxes = [];
						foreach ($PDO->query("SELECT * FROM tax WHERE caser_id='" . $_GET["id"] . "' AND title_id='" . $title["id"] . "'") as $tax) { ?>
						<tr>
							<td><a class="button button-icon" href="<?php echo \system\Core::url();?>/Money/tax/edit?id=<?php echo $tax["id"];?>"><?php echo $Font_awesome->_("Edit icon");?></a></td>
							<td><input type="checkbox" onclick="csi.totalSum(this,'#selected-taxes','<?php echo $tax['count'];?>'); csi.totalSum(this,'#selected-sums','<?php echo $tax['sum'];?>')"></td>
							<td>т.<?php echo $tax["point_number"];?></td>
							<td><?php echo $tax["count"]; $total_taxes["count"] = total($total_taxes, $tax, "count");?></td>
							<td><?php echo $tax["sum"]; $total_taxes["sum"] = total($total_taxes, $tax, "sum");?></td>
							<td><?php echo web\dates::_($tax["date"]);?></td>
							<td><?php echo $tax["note"];?></td>
							<td>
								<?php 
									if ($tax["debtors"] != null) {
										foreach(json_decode($tax["debtors"], true) as $debtor_id){
											?>
											<div><?php echo $PDO->query("SELECT name FROM person WHERE id='" . $debtor_id . "'")->fetch()["name"];?></div>
											<?php
										}
									}
								?>
							</td>
						</tr>
						<?php } ?>
						
						<?php if (!empty($total_taxes)) { ?>
						<tr>
							<th>Избрани</th>
							<th></th>
							<th></th>
							<th id="selected-taxes">0</th>
							<th id="selected-sums"><?php echo \plugin\Money\Money::sum(0);?></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>

						<tr>
							<th>Общо</th>
							<th></th>
							<th></th>
							<th><?php echo $total_taxes["count"];?></th>
							<th><?php echo \plugin\Money\Money::sum($total_taxes["sum"]);?></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
						<?php } ?>
					</table>


					<h3>Дълг</h3>
					<table cellpadding="5" cellspacing="0" class="border-bottom-row">
						<tr>
							<th></th>
							<th></th>
							<th>#</th>
							<th>Вид</th>
							<th>Сума</th>
						</tr>
						<?php 
						$cnt = 0;
						$total_debt = 0;
						foreach ($PDO->query("SELECT * FROM debt WHERE caser_id='" . $_GET["id"] . "' AND title_id='" . $title["id"] . "'") as $debt) { 
								$setting = $PDO->query("SELECT tag,`type` FROM " . $Setting->table . " WHERE id='" . $debt["setting_id"] . "'")->fetch();
								$subsetting = $PDO->query("SELECT tag,`type` FROM " . $Setting->table . " WHERE id='" . $debt["subsetting_id"] . "'")->fetch();
							?>
						<tr>
							<td><a class="button button-icon" href="<?php echo \system\Core::url();?>/Money/debt/edit?id=<?php echo $debt["id"];?>"><?php echo $Font_awesome->_("Edit icon");?></a></td>
							<td><input type="checkbox" onclick="csi.totalSum(this,'#selected-debts','<?php echo $debt["sum"];?>');"></td>
							<td><?php echo ++$cnt;?></td>
							<td><?php echo $setting["type"];?>, <?php echo $subsetting["type"];?></td>
							<td><?php echo $debt["sum"]; $total_debt += $debt["sum"];?></td>
						</tr>
						<?php 
						if ($setting["tag"] == "interest") {
							foreach ($PDO->query("SELECT * FROM debt WHERE link_id='" . $debt["id"] . "' ORDER by start ASC") as $subdebt) { 
								$interest = $Money->interest($subdebt);
								?>
							<tr>
								<td></td>
								<td><input type="checkbox" onclick="csi.totalSum(this,'#selected-debts','<?php echo $interest;?>');"></td>
								<td><?php echo ++$cnt;?></td>
								<td>Законна лихва за <?php echo $subsetting["type"];?> върху <?php echo $subdebt["sum"];?> лева от <?php echo web\dates::_($subdebt["start"]);?></td>
								<td><?php echo $interest; $total_debt += $interest;?></td>
							</tr>
							<?php
							}
						}
					} ?>

						<?php if ($total_debt > 0) { ?>
						<tr>
							<th>Избрани</th>
							<th></th>
							<th></th>
							<th id="selected-debts"><?php echo \plugin\Money\Money::sum(0);?></th>
						</tr>

						<tr>
							<th>Общо</th>
							<th></th>
							<th></th>
							<th><?php echo \plugin\Money\Money::sum($total_debt);?></th>
						</tr>
						<?php } ?>

					</table>
				</div>
			</div>

			
		<?php } ?>
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
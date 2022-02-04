<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Title.php');
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
include_once(\system\Core::doc_root() . '/plugin/Document/php/Document.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Money.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/web/php/dates.php');

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
			<a class="button" href="<?php echo \system\Core::this_path(0, -1);?>/edit?id=<?php echo $_GET["id"];?>">Редакция</a>
		</div>

		<div class="column-9 admin paddingY-40">
			<?php \plugin\Note\Note::listing(" WHERE case_id='" . $_GET["id"] . "' AND hide is NULL ORDER by period DESC, id DESC", $_GET["id"]);?>
		</div>
	</div>
	
	<div id="title" class="text-center">
		<h3>Титули</h3>
		<div>
			Банка по делото: 
			<?php 
				echo $PDO->query("SELECT IBAN FROM bank b LEFT JOIN caser c ON b.id = c.prefBANK WHERE c.id ='" . $_GET["id"] . "'")->fetch()["IBAN"];
			?>
		</div>
		<a class="button" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/add?id=<?php echo $_GET["id"];?>">Добавяне на титул</a>
		<?php foreach($Caser->title as $title){
			$Title = new \plugin\Caser\Title($title["id"]);
			?>
			<div class="clear">
				<div class="column-4 clear text-center">
					<?php $Title->data(); ?>
				</div>
				
				<div class="column-4 padding-10 text-center">
					<div class="column-6">
						<div class="title">Взискатели</div>
						<div class="marginY-20"><a class="button" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/add-person?id=<?php echo $title["id"];?>&type=creditor">Добавяне на взискател</a></div>
						<?php $Title->creditors(); ?>
					</div>
					
					<div class="column-6">
						<div class="title">Длъжници</div>
						<div class="marginY-20"><a class="button" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/add-person?id=<?php echo $title["id"];?>&type=debtor">Добавяне на длъжник</a></div>
						<?php $Title->debtors();?>
					</div>
				</div>

				<div class="column-4 padding-10">
					<div class="title">Дълг</div>
					<h3>Дълг</h3>
					<table cellspacing="5">
						<tr>
							<th>#</th>
							<th>Вид</th>
							<th>Сума</th>
						</tr>
						<?php 
						$cnt = 0;
						foreach ($PDO->query("SELECT * FROM debt WHERE caser_id='" . $_GET["id"] . "' AND title_id='" . $title["id"] . "'") as $debt) { 
								$setting = $PDO->query("SELECT tag,`type` FROM " . $Setting->table . " WHERE id='" . $debt["setting_id"] . "'")->fetch();
								$subsetting = $PDO->query("SELECT tag,`type` FROM " . $Setting->table . " WHERE id='" . $debt["subsetting_id"] . "'")->fetch();
							?>
						<tr>
							<td><?php echo ++$cnt;?></td>
							<td><?php echo $setting["type"];?>, <?php echo $subsetting["type"];?></td>
							<td><?php echo $debt["sum"];?></td>
						</tr>
						<?php 
						if ($setting["tag"] == "interest") {
							foreach ($PDO->query("SELECT * FROM debt WHERE link_id='" . $debt["id"] . "' ORDER by start ASC") as $subdebt) { 
								?>
							<tr>
								<td><?php echo ++$cnt;?></td>
								<td>Законна лихва за <?php echo $subsetting["type"];?> върху <?php echo $subdebt["sum"];?> лева от <?php echo web\dates::_($subdebt["start"]);?></td>
								<td><?php echo $Money->interest($subdebt);?></td>
							</tr>
							<?php
							}
						}
					} ?>
					</table>


					<h3>Такси</h3>
					<table cellspacing="5">
						<tr>
							<th>Точка</th>
							<th>Брой</th>
							<th>Сума</th>
							<th>Дата</th>
							<th>Бележка</th>
							<th>Длъжник</th>
						</tr>
						<?php foreach ($PDO->query("SELECT * FROM tax WHERE caser_id='" . $_GET["id"] . "' AND title_id='" . $title["id"] . "'") as $tax) { ?>
						<tr>
							<td>т.<?php echo $tax["point_number"];?></td>
							<td><?php echo $tax["count"];?></td>
							<td><?php echo $tax["sum"];?></td>
							<td><?php echo web\dates::_($tax["date"]);?></td>
							<td><?php echo $tax["note"];?></td>
							<td><?php if ($tax["debtor_id"] != 0) { echo $PDO->query("SELECT name FROM person WHERE id='" . $tax["debtor_id"] . "'")->fetch()["name"];}?></td>
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
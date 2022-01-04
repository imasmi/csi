<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
include_once(\system\Core::doc_root() . '/plugin/Document/php/Document.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Money.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
\plugin\Note\Note::listing(" WHERE case_id='" . $_GET["id"] . "' AND hide is NULL ORDER by period DESC, id DESC", $_GET["id"]);

$Caser = new \plugin\Caser\Caser($_GET["id"]);
$charger = $PDO->query("SELECT * FROM " . $User->table . " WHERE id='" . $Caser->charger . "'")->fetch();
$Reference = new \plugin\Reference\Reference;
$Document = new \plugin\Document\Document($_GET["id"]);
$Money = new \plugin\Money\Money($_GET["id"]);
?>
<div id="caser">
	<div class="clear">
		<div class="column-6 padding-40 text-center">
			<h2 class="<?php echo $Caser->color;?>"><?php echo $Caser->number;?></h2>
			<div>Статус: <?php echo $Caser->status;?></div>
			<div>Отговорник: <?php echo $charger["email"];?></div>
			<div>Ред статистика: <?php echo $Caser->item["statistic"];?></div>
		</div>
		
		<div class="column-6">
			<div class="column-6">
				<table class="csi">
					<tr>
						<th colspan="100%">Взискатели</th>
					</tr>
					
					<?php foreach($Caser->creditor as $creditor_id){
							$creditor = $PDO->query("SELECT * FROM person WHERE id='" . $creditor_id . "'")->fetch();
						?>
						<tr>
							<td>
								<h3><?php echo $creditor["name"];?></h3>
								<div><?php echo $creditor["EGN_EIK"];?></div>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
			<div class="column-6">
				<table class="csi">
					<tr>
						<th colspan="100%">Длъжници</th>
					</tr>
					
					<?php foreach($Caser->debtor as $debtor_id){
							$debtor = $PDO->query("SELECT * FROM person WHERE id='" . $debtor_id . "'")->fetch();
						?>
						<tr>
							<td>
								<h3><?php echo $debtor["name"];?></h3>
								<div><?php echo $debtor["EGN_EIK"];?></div>
								<div><?php echo $Reference->nap_link($debtor_id, $_GET["id"]);?></div>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
	
	<section id="title" class="text-center">
		<h3 class="tag" onclick="csi.section('#caser #title')">Титули</h3>
		<?php foreach($Caser->title as $title){ ?>
			<div class="clear">
				<h2 class="clear text-center">
					<div><?php echo $title["number"];?></div>
					<div><?php echo $title["date"];?></div>
					<div><?php echo $title["court"];?></div>
					<div><?php echo $title["type"];?></div>
				</h2>
				<div class="column-6 padding-10">
					<div class="column-6">
						<div class="title">Взискатели</div>
						<?php foreach(json_decode($title["creditor"]) as $creditor_id){
								$creditor = $PDO->query("SELECT * FROM person WHERE id='" . $creditor_id . "'")->fetch();
							?>
							<h3><?php echo $creditor["name"];?></h3>
							<div><?php echo $creditor["EGN_EIK"];?></div>
						<?php } ?>
					</div>
					
					<div class="column-6">
						<div class="title">Длъжници</div>
						<?php foreach(json_decode($title["debtor"]) as $debtor_id){
								$debtor = $PDO->query("SELECT * FROM person WHERE id='" . $debtor_id . "'")->fetch();
							?>
							<h3><?php echo $debtor["name"];?></h3>
							<div><?php echo $debtor["EGN_EIK"];?></div>
							<div><?php echo $Reference->nap_link($debtor_id, $_GET["id"]);?></div>
						<?php } ?>
					</div>
				</div>
				
				<div class="column-6 padding-10">
					<div class="title">Дълг</div>
				</div>
			</div>
		<?php } ?>
	</section>
	
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

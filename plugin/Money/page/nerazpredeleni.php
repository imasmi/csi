<?php
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/plugin/Money/php/Money.php');
$Money = new \plugin\Money\Money;
include_once(\system\Core::doc_root() . '/web/php/dates.php');
?>

<div class="csi view">
<table class="listTable" border="1px">
	<tr>
		<th>№</th>
		<th>ID</th>
		<th>Дата</th>
		<th>Изп. дела</th>
		<th>Задължено лице</th>
		<th>Платени</th>
		<th>Неразпределени</th>
		<th>Известия</th>
	<tr>

<?php 
$cnt = 1;
$payed = 0;
$unpartitioned = 0;
$returnSum = 0;
$pdiSum = 0;
$napSum = 0;
$otherSum = 0;
foreach($PDO->query("SELECT * FROM payment WHERE partitioned < allocate AND unpartitioned >= 0 AND user=2 ORDER by date ASC") as $payment){
	$case = $PDO->query("SELECT * FROM caser WHERE id='" . $payment["case_id"] . "'")->fetch();
	$Caser = new \plugin\Caser\Caser($payment["case_id"]);
?>
	<tr>
		<td><?php echo $cnt;?></td>
		<td><?php echo $payment["id"];?></td>
		<td><?php echo \web\dates::_($payment["date"]);?></td>
		<td><?php $Caser->open();?></td>
		<td><?php echo $PDO->query("SELECT name FROM person WHERE id='" . $payment["person"] . "'")->fetch()["name"];?></td>
		<td><?php echo $Money->sum($payment["amount"]);?></td>
		<td><?php echo $Money->sum($payment["unpartitioned"]);?></td>
		<td id="notes<?php echo $Caser->id;?>">
			<?php 
			if(isset($Caser->id)){
				ob_start();
				\plugin\Note\Note::_(" WHERE case_id=" . $Caser->id . " AND payment=1 AND hide is NULL", $Caser->id, "payment", "#notes" . $Caser->id);
				$note = ob_get_contents();
				ob_end_clean();
				echo $note;
			}
			?>
		</td>
	<tr>
<?php
	if(mb_strpos($note, "ВРЪЩ") !== false){
		$returnSum += $payment["unpartitioned"];
	} elseif(mb_strpos($note, "ПДИ") !== false){
		$pdiSum += $payment["unpartitioned"];
	} elseif(mb_strpos($note, "НАП") !== false){
		$napSum += $payment["unpartitioned"];
	} else {
		$otherSum += $payment["unpartitioned"];
	}
	$payed += $payment["amount"];
	$unpartitioned += $payment["unpartitioned"];
	
$cnt++;
}?>

	<tr>
		<td colspan="5"></td>
		<td><?php echo $Money->sum($payed);?></td>
		<td><?php echo $Money->sum($unpartitioned);?></td>
	<tr>
</table>

<table class="listTable" border="1px">
	<tr>
		<td>За връщане:</td>
		<td><?php echo $Money->sum($returnSum);?></td>
	</tr>
	<tr>
		<td>Чака ПДИ:</td>
		<td><?php echo $Money->sum($pdiSum);?></td>
	</tr>
	<tr>
		<td>Чака НАП:</td>
		<td><?php echo $Money->sum($napSum);?></td>
	</tr>
	<tr>
		<td>Други:</td>
		<td><?php echo $Money->sum($otherSum);?></td>
	</tr>
</div>

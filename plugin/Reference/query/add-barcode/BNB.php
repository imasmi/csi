<?php
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Bnb.php');
$Bnb = new \plugin\Reference\Bnb;
include_once(\system\Core::doc_root() . '/plugin/Import/php/Import.php');
$Import = new \plugin\Import\Import;
?>
<form class="form admin" id="form" accept-charset="UTF-8" method="post" action="<?php echo \system\Core::this_path(0, -1);?>/place-BNB" target="_blank">
<table class="listTable napReorder">
	<tr>
		<td>№</td>
		<td></td>
		<td>Дело</td>
	</tr>
	<?php $cnt = 1;?>



<?php 
$cnt = 1;
$used_docs = array();

foreach(\system\Core::list_dir($_POST["dir"]) as $files){
	if(pathinfo($files)["extension"] === "xml"){
		$xml = $Import->xml($files);
		break;
	}
}

foreach($Bnb->_($xml) as $egn => $value){
	$case = NULL;
	$barcode = NULL;
?>
	<tr id="row-<?php echo $cnt;?>">
	<?php
		$person = $PDO->query("SELECT id FROM person WHERE EGN_EIK='" . $egn . "'")->fetch();
		$document = null;
		foreach($PDO->query("SELECT c.id, c.number FROM caser_title t, caser c WHERE c.id=t.case_id AND t.debtor LIKE '%\"" . $person["id"] . "\"%' ORDER by c.number DESC") as $case){
			foreach($PDO->query("SELECT * FROM document WHERE case_id='" . $case["id"] . "' AND type='incoming' AND (name='222' || name='346') ORDER by date ASC, number ASC") as $cur_document){
				if(($document === null || (strtotime($cur_document["date"]) > strtotime($document["date"]))) && !in_array($cur_document["id"], $used_docs)){
					$document = $cur_document;
					$case_numb = $case["number"];
					$case_id = $case["id"];
				}
			}
		}
		$used_docs[] = $document["id"];
	?>
		<td>
			<?php echo $cnt;?>
			<input type="hidden" name="egn_<?php echo $cnt;?>" value="<?php echo $egn;?>"/>
			<input type="hidden" name="value_<?php echo $cnt;?>" value='<?php echo json_encode($value);?>'/>
		</td>
		<td><button type="button" class="button" onclick="S.remove('#row-<?php echo $cnt;?>')">X</button></td>
		<td><?php echo $case_numb;?></td>
		<td><input type="text" name="barcode_<?php echo $cnt;?>" value="<?php echo $document["barcode"];?>"/></td>
	</tr>
	<?php
	$cnt++;
	?>
<?php  
};?>
	<tr><td colspan="100%"><button class="button">Поставяне</button></td></tr>
</table>
<input type="hidden" name="rows" value="<?php echo $cnt;?>"/>
<input type="hidden" name="dateFrom" value="<?php echo $xml["dateFrom"];?>"/>
<input type="hidden" name="dateTo" value="<?php echo $xml["dateTo"];?>"/>
</form>
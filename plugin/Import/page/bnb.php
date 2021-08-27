<?php 
$cnt = 1;
$used_docs = array();
$Bnb = new \plugin\Reference\php\Bnb;
$Barcode = new \plugin\Document\php\Barcode;

foreach($Bnb->_($xml) as $egn => $value){?>
	<div class="person">
			<table id="bulLion">	
				<tr>
					<td rowspan="2"><img src="<?php echo $Core->url() . $File->items[1]["path"];?>"/></td>
					<td>БЪЛГАРСКА НАРОДНА БАНКА</td>
				</tr>	

				<tr>
					<td>РЕГИСТЪР НА БАНКОВИТЕ СМЕТКИ И СЕЙФОВЕ</td>
				</tr>		
			</table>

			<h4 id="checkTitle">СПРАВКА ЗА БАНКОВИ СМЕТКИ И СЕЙФОВЕ НА ФИЗИЧЕСКО/ЮРИДИЧЕСКО ЛИЦЕ</h4>
			
			<h5>Електронната справка е изготвена от ЧСИ ГЕОРГИ  ЦЕНОВ ТАРЛЬОВСКИ.</h5>
			
			<table border="1px" class="bnbTable personData">	
				<tr>
					<td class="boldTD">Основание за справката, чл. 56а от ЗКИ и Наредба 12 на БНБ, чл. 11</td>
					<td><?php echo $Bnb->caser($egn);?></td>
				</tr>			
			</table>
			
			<?php 
				$person = $Query->select($egn, "EGN_EIK", "person", "id");
				$document = null;
				foreach($PDO->query("SELECT c.id, c.number FROM caser_title t, caser c WHERE c.id=t.case_id AND t.debtor LIKE '%\"" . $person["id"] . "\"%' ORDER by c.number DESC") as $case){
					foreach($PDO->query("SELECT * FROM document WHERE case_id='" . $case["id"] . "' AND type='incoming' AND (name='222' || name='346') ORDER by date ASC, number ASC") as $cur_document){
						if(($document === null || (strtotime($cur_document["date"]) > strtotime($document["date"]))) && !in_array($cur_document["id"], $used_docs)){$document = $cur_document;}
					}
				}
				$used_docs[] = $document["id"];
				$bnbID = 'bnbBar'. $cnt;
			?>
			<div class="bnbBar" id="<?php echo $bnbID;?>">
				<?php $Barcode->_($document, $bnbID);?>
			</div>

			<table border="1px" class="bnbTable personData">	
				<tr>
					<td class="boldTD">ПЕРИОД НА СПРАВКАТА</td>
					<td><?php echo $xml["dateFrom"];?> г. - <?php echo $xml["dateTo"];?> г.</td>
				</tr>			
			</table>

			<table border="1px" class="bnbTable personData">
				<tr><td class="boldTD">ДАННИ ЗА ЛИЦЕТО</td></tr>
				<tr><td>ДЪРЖАВА, ИЗДАЛА ИДЕНТИФИКАТОР: BULGARIA;<br/> ИДЕНТИФИКАТОР: <?php echo $Bnb->bnb_id($value[0]["identity_type"]) . " " . $egn;?></td></tr>	
			</table>
			
	<?php 
		#DISPLAY BANK ACCOUNTS FOR USER
		$Bnb->accounts($value[0]["bank"]);
		
		#DISPLAY BANK SAFES FOR USER
		$Bnb->safes($value[0]["safes"]);
	?>
	
	<?php if(isset($value[1])){?>
		<br/>
		<h5>ДАННИ ЗА ЛИЦЕ, УПРАЖНЯВАЩО СВОБОДНА ПРОФЕСИЯ ИЛИ ЗАНАЯТЧИЙСКА ДЕЙНОСТ<br/>С ИДЕНТИФИКАТОР: <?php echo $egn;?>;</h5>
	
	<?php 
	
		#DISPLAY BANK ACCOUNTS FOR USER'S BULSTAT
		$Bnb->accounts($value[1]["bank"]);
		
		#DISPLAY BANK ACCOUNTS FOR USER'S BULSTAT
		$Bnb->safes($value[1]["safes"]);
	} ?>
	
		<h5>Съгласно чл. 8 от Наредба № 12 за Регистъра на банковите сметки и сейфове, банките носят отговорност за верността, пълнотата и своевременното подаване на информацията. Българската народна банка не извършва корекции в регистъра, освен за подаваната от нея информация.</h5>
		<div>Дата: <?php echo date("d.m.Y г.,H:i ч.", strtotime($value[0]["processed_time"]));?></div>
			
</div>
<?php 
$cnt++;
};?>
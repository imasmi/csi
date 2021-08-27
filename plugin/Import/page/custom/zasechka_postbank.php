<form method="post" action="<?php echo $Import->qwdir;?>/incomings" target="_blank">
	<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
		
		<tr><th colspan="100%">Засечка на банка</th></tr>
		<tr>
			<th>Открити</th>
			<th>Сума</th>
			<th>Дата</th>
			<th>Подател</th>
			<th>Описание</th>
			<th>Номер</th>
			<th>№</th>
		</tr>

		<?php
		$a = 1;
		$curDate = 0;
		$total = 0;
		$monthPays = array();
		$weekPays = array();
		$movements = $xml->ArrayOfAPAccounts->APAccount->BankAccount->Movements->ArrayOfMovements;
		foreach($movements->BankAccountMovement as $movement){
		$moveAmount = (float)$movement->AmountLocalCCY;
		$total += $moveAmount;
		$moveTime = $date->change($movement->ProcessTimestamp);
		
		for($m = 1; $m < 13; $m++){
			if(date("n", strtotime($moveTime)) == $m){$monthPays[$m] += $moveAmount;}
		}
		
		for($w = 1; $w < 53; $w++){
			if(date("W", strtotime($moveTime)) == $w){$weekPays[date("Y-m-d", strtotime(date("Y-01-00",strtotime($moveTime)) . "+" . (($w - 1)  * 7 - 2) . " days"))] += $moveAmount;}
		}
		
		
		$check = $PDO->query("SELECT id FROM payment WHERE date LIKE '" . $moveTime . "' AND amount='" . $moveAmount  . "'");
		$findedPays = $check->rowCount();
		if($findedPays == 0){
			$class = 'class="color2bg"';
		} elseif($findedPays > 1){
			$class = 'class="color4bg"';
		} else {
			$class = "";
		}
		?>
		
		<?php if($moveTime != $curDate){ ?>
		<tr><th colspan="100%"><?php echo $moveTime;?></th></tr>
		<?php 
		$curDate = $moveTime;
		}?>
		<tr <?php echo $class;?>>
			<td><?php echo $findedPays;?></td>
			<td><?php echo $moveAmount;?></td>
			<td><?php echo $moveTime;?></td>
			<td><?php echo $movement->MovementDocument->PayerName;?></td>
			<td><?php echo $movement->MovementDocument->Description;?></td>
			<td><?php echo $movement->DocRegNumber;?></td>
			<td><?php echo $a;?></td>
		</tr>
		<?php 
		$a++;
		} ?>
		
		<tr><td colspan="100%">Общо: <b><?php echo $pay->sum_format($total);?></b></td></tr>
		<tr><td colspan="100%">Преводи: <?php echo $a - 1;?></td></tr>
		
		<?php foreach($monthPays as $month => $sum){ ?>
			<tr><td colspan="100%"><?php echo $month;?>: <b><?php echo $pay->sum_format($sum);?></b></td></tr>
		<?php }?>
		
		<?php foreach($weekPays as $week => $sum){ ?>
			<tr><td colspan="100%"><?php echo $week;?> - <?php echo date("Y-m-d", strtotime($week . " 4 days"));?>: <b><?php echo $pay->sum_format($sum);?></b></td></tr>
		<?php }?>
	<table>
</form>

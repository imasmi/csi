<?php if($User->role !== false){?>
<div class="logger text-right">
	<div><?php echo $User->item["email"];?></div>
	<a href="<?php echo $Core->url();?>User/query/logout">Излез</a>
</div>
<ul id="csi-menu">
	<li>
		<a href="<?php echo $Core->url();?>Note/index">Събития</a>
		<ul class="sub-menu">
			<li><a href="<?php echo $Core->url();?>Statistic/collected-money">Събрани суми</a></li>
		</ul>
	</li>
	<li><a href="<?php echo $Core->url();?>Caser/index">Дела</a></li>
	<li><a href="<?php echo $Core->url();?>Document/incoming">Входящи</a></li>
	<li><a href="<?php echo $Core->url();?>Document/outgoing">Изходящи</a></li>
	<li><a href="<?php echo $Core->url();?>Document/protocol">Протоколи</a></li>
	<li>
		<a>Пари</a>
		<ul class="sub-menu">
			<li><a href="<?php echo $Core->url();?>Money/payment/index">Плащания</a></li>
			<li><a href="<?php echo $Core->url();?>Money/invoice/index">Фактури</a></li>
			<li><a href="<?php echo $Core->url();?>Money/proverka">Проверка преди погасяване</a></li>
			<li><a href="<?php echo $Core->url();?>Money/nerazpredeleni">Неразпределени</a></li>
			<li><a href="<?php echo $Core->url();?>Money/postbank-payments">Пощенска банка</a></li>
			<li><a href="<?php echo $Core->url();?>Money/distribution">Разпределения</a></li>
			<li><a href="<?php echo $Core->url();?>Money/proporcionalnost">Пропорционалност</a></li>
			<li><a href="<?php echo $Core->url();?>Money/tax-pay">Плащане на такси</a></li>
			<li><a href="<?php echo $Core->url();?>Money/bank/unit/index">Банки</a></li>
		</ul>
	</li>
	<li>
		<a>Справки</a>
		<ul class="sub-menu">
			<li><a href="<?php echo $Core->url();?>Reference/index">Справки</a></li>
			<li><a href="<?php echo $Core->url();?>Reference/starters">Стартови</a></li>
			<li><a href="<?php echo $Core->url();?>Reference/reorder-dir-by-cases">Пренареждане на дела</a></li>
			<li><a href="<?php echo $Core->url();?>Reference/add-barcode">Поставяне на баркод</a></li>
			<li><a href="<?php echo $Core->url();?>Reference/report">Отчет</a></li>
		</ul>
	</li>
	<li><a href="<?php echo $Core->url();?>Person/index">Лица</a></li>
	<li><a href="<?php echo $Core->url();?>Import/index">Импорт</a></li>
</ul>

<div class="head-field">
	<form action="<?php echo $_SERVER["REQUEST_URI"];?>">
		<input type="date" name="start" placeholder="Начална дата,дата" value="<?php echo ((isset($_GET["start"])) ?  $_GET["start"] : "");?>"/>
		<br/>
		<input type="date" name="end" placeholder="Крайна дата,Дело,Такса" value="<?php echo ((isset($_GET["end"])) ?  $_GET["end"] : "");?>"/>
		<input type="submit" class="button" value="Изпрати"/>
	</form>
</div>
<div class="head-field text-center">
	<div>Напове<br/>за деня:</div>
	<?php
		$day_naps = $PDO->query("SELECT note FROM document WHERE `type` = 'outgoing' AND (name=4 OR name=5) AND date='" . date("Y-m-d") . "' GROUP BY note");
		echo $day_naps->rowCount();
	?>
</div>
<div id="header-searches" class="head-field">
	<div class="head-opener">
		<div class="inline-block"><?php echo $Caser->select("headCaseChoose");?></div>
		<button class="button" onclick="if(S('#headCaseChoose').value != ''){window.open('<?php echo $Core->url() . "Caser/open?id=";?>' + S('#headCaseChoose').value, '_blank');} else {S.info('Не е намерено изпълнително дело!');}">Дело</button>
	</div>

	<form onsubmit="if(S('#header_search').value == ''){ return false;}; return S.popup('<?php echo $Core->url() . 'query/header-search';?>', {search: S('#header_search').value})">
		<input type="text" id="header_search" placeholder="Търсене"/>
		<button class="button">Търсене</button>
	</form>
</div>


<?php } ?>

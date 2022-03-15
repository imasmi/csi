

<div class="flex flex-between">
	
	<div id="header-logo" class="padding-right-30"><?php echo $File->_("Logo header");?></div>
<?php if($User->id !== false){?>

	<ul id="csi-menu">
		<li>
			<a href="<?php echo \system\Core::url();?>Note/index">Събития</a>
			<ul class="sub-menu">
				<li><a href="<?php echo \system\Core::url();?>Statistic/collected-money">Събрани суми</a></li>
			</ul>
		</li>
		<li><a href="<?php echo \system\Core::url();?>Caser/index">Дела</a></li>
		<li><a href="<?php echo \system\Core::url();?>Document/incoming">Входящи</a></li>
		<li><a href="<?php echo \system\Core::url();?>Document/outgoing">Изходящи</a></li>
		<li><a href="<?php echo \system\Core::url();?>Document/protocol">Протоколи</a></li>
		<li>
			<a>Пари</a>
			<ul class="sub-menu">
				<li><a href="<?php echo \system\Core::url();?>Money/payment/index">Плащания</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/invoice/index">Фактури</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/proverka">Проверка преди погасяване</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/nerazpredeleni">Неразпределени</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/postbank-payments">Пощенска банка</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/distribution">Разпределения</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/proporcionalnost">Пропорционалност</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/tax-pay">Плащане на такси</a></li>
				<li><a href="<?php echo \system\Core::url();?>Money/bank/unit/index">Банки</a></li>
			</ul>
		</li>
		<li>
			<a>Справки</a>
			<ul class="sub-menu">
				<li><a href="<?php echo \system\Core::url();?>Reference/index">Справки</a></li>
				<li><a href="<?php echo \system\Core::url();?>Reference/starters">Стартови</a></li>
				<li><a href="<?php echo \system\Core::url();?>Reference/reorder-dir-by-cases">Пренареждане на дела</a></li>
				<li><a href="<?php echo \system\Core::url();?>Reference/add-barcode">Поставяне на баркод</a></li>
				<li><a href="<?php echo \system\Core::url();?>Reference/report">Отчет</a></li>
			</ul>
		</li>
		<li><a href="<?php echo \system\Core::url();?>Person/index">Лица</a></li>
		<li><a href="<?php echo \system\Core::url();?>Import/index">Импорт</a></li>
	</ul>

	<div id="header-searches" class="head-field head-opener padding-right-20">
		<span class="inline-block relative">
			<div class="inline-block"><?php echo $Caser->select("headCaseChoose");?></div>
			<button class="button search-button" onclick="if(S('#headCaseChoose').value != ''){window.open('<?php echo \system\Core::url() . "Caser/open?id=";?>' + S('#headCaseChoose').value, '_blank');} else {S.info('Не е намерено изпълнително дело!');}"><?php echo $Font_awesome->_("Search icon");?></button>
		</span>
		<form onsubmit="if(S('#header_search').value == ''){ return false;}; return S.popup('<?php echo \system\Core::url() . 'query/header-search';?>', {search: S('#header_search').value})" class="relative inline-block">
			<input type="text" id="header_search" placeholder="Търсене"/>
			<button class="button search-button"><?php echo $Font_awesome->_("Search icon");?></button>
		</form>
	</div>

	<div class="head-field">
		<div id="filters" class="header-item">
			<div><?php echo $Font_awesome->_("Filters icon");?>Филтри</div>
			<div id="filters-select" class="hide absolute drop-down black padding-20">
				<div>Избери дати</div>
				<form action="<?php echo $_SERVER["REQUEST_URI"];?>" class="margin-top-10">
					<input type="date" name="start" value="<?php echo ((isset($_GET["start"])) ?  $_GET["start"] : "");?>"/>
					<br/>
					<input type="date" name="end" value="<?php echo ((isset($_GET["end"])) ?  $_GET["end"] : "");?>"/>
					<input type="submit" class="button" value="Изпрати"/>
				</form>
				<div class="margin-top-10">Пуснати напове<br/>за деня:</div>
				<?php
					$day_naps = $PDO->query("SELECT note FROM document WHERE `type` = 'outgoing' AND (name=4 OR name=5) AND date='" . date("Y-m-d") . "' GROUP BY note");
					echo $day_naps->rowCount();
				?>
			</div>
		</div>
	</div>
	

	<div class="logger text-right">
		<div><?php echo $User->item["email"];?></div>
		<a href="<?php echo \system\Core::url();?>User/query/logout">Излез</a>
	</div>
<?php } ?>
</div>



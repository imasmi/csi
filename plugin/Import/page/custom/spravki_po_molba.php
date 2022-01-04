<?php
$caser = array();
for($a = 1; $a < count($csv); $a++){
	$caser[] =  $PDO->query("SELECT id FROM caser WHERE number='" . $csv[$a][2] . "'")->fetch()["id"];
}

# ФУНКЦИЯ ЗА СТАРТОВИ СПРАВКИ ПО ДЕЛАТА
$Reference = new \plugin\Reference\php\Reference;
?>
<div class="admin">
<?php
$Reference->starters(array_unique($caser));
?>
</div>
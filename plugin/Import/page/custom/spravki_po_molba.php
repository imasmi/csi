<?php
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
$Reference = new \plugin\Reference\Reference;
$caser = array();
for($a = 1; $a < count($csv); $a++){
	$caser[] =  $PDO->query("SELECT id FROM caser WHERE number='" . $csv[$a][2] . "'")->fetch()["id"];
}

# ФУНКЦИЯ ЗА СТАРТОВИ СПРАВКИ ПО ДЕЛАТА
?>
<div class="admin">
<?php
$Reference->starters(array_unique($caser));
?>
</div>
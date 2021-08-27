<?php
$caser = array();
for($a = 1; $a < count($csv); $a++){
	$caser[] =  $Query->select($csv[$a][2], "number", "caser", "id")["id"];
}

# ФУНКЦИЯ ЗА СТАРТОВИ СПРАВКИ ПО ДЕЛАТА
$Reference = new \plugin\Reference\php\Reference;
?>
<div class="admin">
<?php
$Reference->starters(array_unique($caser));
?>
</div>
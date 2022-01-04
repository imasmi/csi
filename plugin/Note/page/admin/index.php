<?php
$dir = \system\Core::this_path(0,-2);
$actions = array(
	"add" => $dir . "/add",
	"admin" => $dir . "/view",
	"edit" => $dir . "/edit",
	"hide" => $dir . "/hide"
	
);
?>

<div class="admin">
<div class="title">Бележки</div>
<?php
echo \system\Query::listing("*", $actions, "note", "");
#\system\Query::listing($array="*", $actions="*", $table="module", $where="")
?>
</div>
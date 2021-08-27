<?php
$dir = $Core->this_path(0,-2);
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
echo $Query->listing("*", $actions, "note", "");
#$Query->listing($array="*", $actions="*", $table="module", $where="")
?>
</div>
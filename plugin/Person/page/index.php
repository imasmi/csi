<?php
require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
$ListingAPP = new \module\Listing\ListingAPP;
$fields = array(
        "#" => "id", 
        "Name" => "name",
        "Egn" => "EGN_EIK",
        "Type" => "type",
        "Budget" => "budget",
		"Nap" => "nap"
);

$dir = \system\Core::this_path(0, -1);
$actions = array(
	"add" => $dir . "/add",
	"edit" => $dir . "/edit",
	"bank" => \system\Core::url() . "Money/bank/index?person",
	"notes" => $dir . "/notes"
);
?>

<div class="admin">
<div class="title">Title</div>
<?php
echo $ListingAPP->_($fields, $actions, "person");
?>
</div>
<?php
$fields = array(
        "#" => "id", 
        "Name" => "name",
        "Egn" => "EGN_EIK",
        "Type" => "type",
        "Budget" => "budget",
		"Nap" => "nap"
);

$dir = $Core->this_path(0, -1);
$actions = array(
	"edit" => $dir . "/edit",
	"bank" => $Core->url() . "Money/bank/index?person",
	"notes" => $dir . "/notes"
);
?>

<div class="admin">
<div class="title">Title</div>
<?php
if($User->_() != "admin"){require_once($Core->doc_root() . "/system/module/Listing/php/ListingAPP.php");}
$ListingAPP = new \system\module\Listing\php\ListingAPP;
echo $ListingAPP->_($fields, $actions, "person");
#$Query->listing($array="*", $actions="*", $table="module", $where="")
?>
</div>
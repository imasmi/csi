<?php
$dir = $Core->this_path(0,-1);

$array = array(
	"Информация" => "bg",
	"Сума" => "value"
);

$actions = array(
    "add" => $dir . "/add?id=" . $_GET["id"],
    "edit" => $dir . "/edit",
    "delete" => $dir . "/delete"
);
?>

<div class="admin">
    <?php 
        $ListingAPP = new \system\module\Listing\php\ListingAPP;
        $ListingAPP->_($array, $actions, $Setting->table, "WHERE fortable='payment' AND page_id='" . $_GET["id"] . "' AND tag='refund'");
    ?>
	<button type="button" class="button block center" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
</div>
<?php
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
$ListingAPP = new \module\Listing\ListingAPP;
$Object = $Plugin->object();
$dir = \system\Core::this_path(0,-1);

$actions = array(
    "choose" => $dir . "/index?creditor"
);
?>

<div class="admin">
	<h1 class="text-center">Лица</h2>
	<?php 
		
		$ListingAPP->_(["name" => "name", "type" => "type"], $actions, "person", "ORDER by name ASC");
	?>
</div>
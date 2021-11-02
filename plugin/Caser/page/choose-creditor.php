<?php
$Object = $Plugin->object();
$dir = $Core->this_path(0,-1);

$actions = array(
    "choose" => $dir . "/index?creditor"
);
?>

<div class="admin">
	<h1 class="text-center">Лица</h2>
	<?php 
		$ListingAPP = new \system\module\Listing\php\ListingAPP;
		$ListingAPP->_(["name" => "name", "type" => "type"], $actions, "person", "ORDER by name ASC");
	?>
</div>
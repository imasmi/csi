<?php
$Object = $Plugin->object();
$dir = $Core->this_path(0,-1);

$actions = array(
    "add" => $dir . "/add",
    "admin" => $dir . "/view",
    "edit" => $dir . "/edit",
    "settings" => $Core->url() . "Page/admin/settings",
    "delete" => $Core->url() . "Page/admin/delete"
);
?>

<div class="admin">
	<h1 class="text-center">Изпълнителни дела</h2>
	<table class="listing">
		<tr>
			<th>Номер</th>
			<th>Статус</th>
			<th>Взискатели</th>
			<th>Длъжници</th>
			<th>Погасено</th>
			<th></th>
		</tr>
		<?php
		$cases = array();	
		foreach($PDO->query("SELECT * FROM caser ORDER by number DESC") as $case){
			$cases[] = $case;
		}
		$ListingAPP = new \system\module\Listing\php\ListingAPP;
		foreach($ListingAPP->page_slice($cases) as $case){
			$title = $Query->select($case["id"], "case_id", "caser_title");		
		?>
		<tr>
			<td><?php echo $case["number"];?></td>
			<td class="<?php echo $Caser->color($case["status"]);?>"><?php echo $case["status"];?></td>
			<td>
				<?php 
					foreach(json_decode($title["creditor"]) as $creditor){
						$Person = new \plugin\Person\php\Person($creditor);
						$Person->_();
					}
				?>
			</td>
			<td>
				<?php 
					foreach(json_decode($title["debtor"]) as $debtor){
						$Person = new \plugin\Person\php\Person($debtor);
						$Person->_();
					}
				?>
			</td>
			<td></td>
			<td><a class="button" href="<?php echo $Core->this_path(0,-1);?>/open?id=<?php echo $case["id"];?>"><?php echo $Text->item("open");?></a></td>
		</tr>
		<?php } ?>
	</table>
	<?php echo $ListingAPP->pagination(count($cases));?>	
</div>

<?php
$Object = $Plugin->object();
$dir = \system\Core::this_path(0,-1);
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
include_once(\system\Core::doc_root() . '/system/module/Listing/php/ListingAPP.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
$Reference = new \plugin\Reference\Reference;

$actions = array(
    "add" => $dir . "/add",
    "admin" => $dir . "/view",
    "edit" => $dir . "/edit",
    "settings" => \system\Core::url() . "Page/admin/settings",
    "delete" => \system\Core::url() . "Page/admin/delete"
);
?>

<div class="admin">
	<a class="button" href="<?php echo $dir;?>/choose-creditor">Избери взискател</a>
	<h1 class="text-center">Изпълнителни дела</h2>
	<table class="listing">
		<tr>
			<th>Номер</th>
			<th>Статус</th>
			<th>Взискатели</th>
			<th>Длъжници</th>
			<th>Погасено</th>
			<th></th>
			<th></th>
		</tr>
		<?php
		$cases = array();
		if (isset($_GET["creditor"])) {
			foreach($PDO->query("SELECT case_id FROM caser_title WHERE creditor LIKE '%\"" . $_GET["creditor"] ."\"%'") as $caser_title){
				$case = $PDO->query("SELECT * FROM caser WHERE id='" . $caser_title["case_id"] . "'")->fetch();
				if($case["status"] == "ВИСЯЩО") {
					$cases[$case["number"]] = $case;
				}
			}
			ksort($cases);
		} else {
			foreach($PDO->query("SELECT * FROM caser ORDER by number DESC") as $case){
				$cases[] = $case;
			}
		}
		$ListingAPP = new \module\Listing\ListingAPP;
		foreach($ListingAPP->page_slice($cases) as $case){
			$title = $PDO->query("SELECT * FROM caser_title WHERE case_id='" . $case["id"] . "'")->fetch();;
		?>
		<tr>
			<td><?php echo $case["number"];?></td>
			<td class="<?php echo $Caser->color($case["status"]);?>"><?php echo $case["status"];?></td>
			<td>
				<?php 
					foreach(json_decode($title["creditor"]) as $creditor){
						$Person = new \plugin\Person\Person($creditor);
						$Person->_();
					}
				?>
			</td>
			<td>
				<?php 
					foreach(json_decode($title["debtor"]) as $debtor){
						$Person = new \plugin\Person\Person($debtor);
						$Person->_();
						$Reference->nap_link($debtor, $case["id"]);
						?>
						<div><a href="<?php echo \system\Core::url();?>Reference/noi?case=<?php echo $case["id"];?>&person=<?php echo $debtor;?>&type=0" class="getNap" target="_blank">Трудови договори</a></div>
						<?php 
					}
				?>
			</td>
			<td><?php \plugin\Note\Note::_(" WHERE case_id=" . $case["id"] . " AND spravki=1 AND hide is NULL", $case["id"], "spravki", "#notes" . $case["id"]);?></td>
			<td><a class="button" href="<?php echo \system\Core::this_path(0,-1);?>/open?id=<?php echo $case["id"];?>"><?php echo $Text->item("open");?></a></td>
		</tr>
		<?php } ?>
	</table>
	<?php echo $ListingAPP->pagination(count($cases));?>	
</div>

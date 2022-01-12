<?php
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Reference.php');
$Reference = new \plugin\Reference\Reference;
?>
<div class="admin view">
<?php $startYear = (isset($_GET["year"])) ? $_GET["year"] : date("Y");?>
<form class="center text-center" id="yearChanger" action="<?php echo $_SERVER["REQUEST_URI"];?>">
<select name="year" onchange="$('#yearChanger').submit()">
	<?php foreach($Caser->years() as $year){?>
	<option value="<?php echo $year;?>" <?php if($year == $startYear){ echo 'selected';;}?>><?php echo $year;?></option>
	<?php } ?>
</select>
</form>


<?php
	$cases = array();
		foreach($PDO -> query("SELECT id FROM caser WHERE status = '55' AND pusnati_startovi=0 AND no_startovi=0 AND number>'" . $startYear . "0000000000' AND noNap = '0' ORDER by number ASC") as $case){
			$Caser = new \plugin\Caser\Caser($case["id"]);
			if($Caser->title_main["type"] != 82){
				$cases[] = $case["id"];
			}
		}
	$Reference->starters($cases);
?>


<form method="post" action="<?php echo \system\Core::query_path(0, -1);?>/remove-from-startovi">
	<?php foreach($cases as $case_id){?>
		<input type="hidden" name="<?php echo $case_id;?>" id="startovi_<?php echo $case_id;?>" value="1"/>
	<?php } ?>
	<button class="button">Премахни от стартови</button>
</form>
</div>

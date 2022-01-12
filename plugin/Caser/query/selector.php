<?php 
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
#FIND CASES BY NUMBER
if($_POST["data"] == ""){
	?>
		<script>csi.selector('<?php echo $_POST["id"];?>', '', '')</script>
	<?php
	exit;
}
$len = strlen($_POST["data"]);
$cNumb = (strlen($_POST["data"]) > 5) ? $_POST["data"] : 400000 + $_POST["data"];
$select_list = $PDO->query("SELECT * FROM caser WHERE number LIKE '%" . $cNumb . "' ORDER by number DESC");
$finded_numb = $select_list->rowCount();
if($finded_numb > 0){
	if($len > 5 && $finded_numb == 1){
		$fc = $select_list->fetch();
	?>
	<script> csi.selector('<?php echo $_POST["id"];?>', '<?php echo $fc["id"];?>', '<?php echo $fc["number"];?>')</script>
	<?php
	} else {
		foreach($select_list as $fc){
		$Caser = new \plugin\Caser\Caser($fc["id"]);	
		?>
			<div class="select-item <?php echo $Caser->color;?>" onclick="csi.selector('<?php echo $_POST["id"];?>', '<?php echo $fc["id"];?>', '<?php echo $fc["number"];?>')"><?php echo $fc["number"];?></div>
		<?php 
		} 
	}
}?>
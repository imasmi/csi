<?php 
if(strlen($_POST["data"]) > 2){
foreach($PDO->query("SELECT * FROM person WHERE EGN_EIK LIKE '%" . $_POST["data"] . "%' OR name LIKE '%" . $_POST["data"] ."%' ORDER by name ASC") as $select){?>
	<div class="select-item" onclick="csi.selector('<?php echo $_POST["id"];?>', '<?php echo $select["id"];?>', '<?php echo $select["name"];?>')"><?php echo $select["name"] . ' -> ' . $select["EGN_EIK"];?></div>
<?php }}?>
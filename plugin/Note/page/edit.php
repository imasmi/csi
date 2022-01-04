<?php 
$select = $PDO->query("SELECT * FROM note WHERE id='" . $_GET["id"] . "'")->fetch();
$Caser = new \plugin\Caser\php\Caser($select["case_id"]);
?>
<div class="admin">
<div class="title">Редакция на бележка</div>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#errorMessage')">
    <table class="table">
        <tr>
            <td>Бележка</td>
            <td><textarea type="text" name="note" id="note" class="noteField" onchange="csi.trim(this)" required><?php echo $select["note"];?></textarea>
        </tr>
		
		<tr>
            <td>Дело</td>
            <td>
				<?php $Caser->select("case", array("id" => $Caser->id));?>
				<input type="hidden" name="case_id" id="case_id" value="<?php echo $Caser->id;?>"/>
				<script>
					document.getElementById("case_selector").addEventListener("click", function(){
						setTimeout(function(){
							S.post('<?php echo \system\Core::query_path(0, -1);?>/case_debtors', {'case_id' : S('#case_id').value}, '#debtors');
						}, 100);
					});
				</script>
			</td>
        </tr>
		
		<tr>
            <td>Бързи действия</td>
            <td>
				<select name="quick_action" onchange="csi.noteQuick(this)">
					<option>Избери</option>
					<option value="pdi">Чака ПДИ</option>
					<option value="nap">Чака НАП</option>
				</select>
			</td>
        </tr>
		
		<tr>
            <td>Длъжник</td>
            <td id="debtors">
				<?php
					if($select["case_id"] != "0"){
						foreach($Caser->debtor as $id){
							$debtors[$id] = $PDO->query("SELECT name FROM person WHERE id='" . $id . "'")->fetch()["name"];
						}	
						$Form->select("debtor_id", $debtors, array("select" => $select["debtor_id"]));
					}
				?>
			</td>
        </tr>
		
		<tr>
            <td>Потребител</td>
            <td>
				<?php
				$users = array();
				foreach($PDO->query("SELECT * FROM " . $User->table . " WHERE `status` = 'active' ORDER by email ASC") as $user){
					$users[$user["id"]] = $user["email"];
				}
					$Form->select("user_id", $users, array("select" => $select["user_id"]));
				?>
			</td>
        </tr>
		
		<tr>
            <td>Документ</td>
            <td><input type="text" name="doc_id" id="doc_id" value="<?php echo $select["doc_id"];?>"/></td>
        </tr>
		<?php $period = ($select["period"] === "0000-00-00 00:00:00") ? false : true;?>
		<tr>
            <td>Период</td>
            <td>
				<input type="checkbox" name="usePeriod" id="usePeriod" onchange="S.toggle('#period-changer')" <?php if($period){ echo 'checked';}?>/>
				<span id="period-changer" class="<?php echo $period ? 'block' :'hide"';?>">
					<input type="date" name="date" value="<?php echo date("Y-m-d", strtotime($select["period"]));?>"/>
					<input type="time" name="time" value="<?php echo date("H:i:s", strtotime($select["period"]));?>"/>
				</span>
			</td>
        </tr>
		
		<tr><th colspan="100%">Показване</th></tr>
		
		<tr>
            <th>Навсякъде</th>
            <td><input type="checkbox" onchange="S.checkAll(this, '.notePlace')"/></td>
        </tr>
	<?php
	$check = (isset($_GET["check"])) ? explode(",", $_GET["check"]) : array(); 
	foreach($Note->places() as $key=>$value){
	?>
		<tr>
            <td><?php echo $value;?></td>
            <td><input type="checkbox" name="<?php echo $key;?>" class="notePlace" id="<?php echo $key;?>" <?php if($select[$key] == 1){ echo 'checked';};?>/></td>
        </tr>
	<?php }?>
        
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>

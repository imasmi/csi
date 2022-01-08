<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
include_once(\system\Core::doc_root() . '/plugin/Note/php/Note.php');
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
$Caser = new \plugin\Caser\Caser($_GET["case_id"]);
?>
<div class="admin">
<div class="title">Добавяне на бележкa</div>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#errorMessage')">
    <table class="table">
        <tr>
            <td>Бележка</td>
            <td><textarea type="text" name="note" id="note" class="noteField" onchange="csi.trim(this)" required></textarea>
        </tr>

		<tr>
            <td>Дело номер</td>
            <td>
				<?php 
				$Caser->select("case", array("id" => $_GET["case_id"]));?>
				<input type="hidden" name="case_id" id="case_id" value="<?php if(isset($_GET['case_id'])){echo $_GET['case_id'];}?>"/>
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
					if(isset($_GET["case_id"]) ){
						foreach($Caser->debtor as $id){
							$debtors[$id] = $PDO->query("SELECT name FROM person WHERE id='" . $id . "'")->fetch()["name"];
						}	
						\system\Form::select("debtor_id", $debtors);
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
				\system\Form::select("user_id", $users);
				?>
			</td>
        </tr>
		
		<tr>
            <td>Документ</td>
            <td><input type="text" name="doc_id" id="doc_id"/></td>
        </tr>

		<tr>
            <td>Период</td>
            <td>
				<input type="checkbox" name="usePeriod" id="usePeriod" onchange="S.toggle('#periodChanger')"/>
				<span id="periodChanger" class="hide">
					<input type="date" name="date" value="<?php echo date('Y-m-d');?>"/>
					<input type="time" name="time" value="08:00:00"/>
				</span>
			</td>
        </tr>

		<tr><th colspan="100%">Показване</th></tr>

		<tr>
            <td>Навсякъде</td>
            <td><input type="checkbox" onchange="S.checkAll(this, '.notePlace')"/></td>
        </tr>
	<?php

	$check = (isset($_GET["check"])) ? explode(",", $_GET["check"]) : array();

	foreach(\plugin\Note\Note::places() as $key=>$value){
	?>
		<tr>
            <td><?php echo $value;?></td>
            <td><input type="checkbox" name="<?php echo $key;?>" id="<?php echo $key;?>" <?php if(in_array($key, $check)){ echo 'checked';};?>/></td>
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

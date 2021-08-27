<?php 
	$select = $Query->select($_GET["person"], "id", "person");
	$units = array();
	foreach($PDO->query("SELECT * FROM bank_units ORDER by id ASC") as $unit){
		$units[$unit["id"]] = $unit["name"];
	}
?>
<div class="admin">
<div class="title">Добавяне на банова сметка: <?php echo $select["name"];?></div>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo $Core->query_path();?>" method="post">
    <input type="hidden" name="person_id" value="<?php echo $_GET["person"];?>"/>
	<table class="table">
        <tr>
            <td>Банка</td>
            <td><?php $Form->select("bank_unit", $units);?></td>
        </tr>
        
		<tr>
            <td>IBAN</td>
            <td><input type="text" name="IBAN" required /></td>
        </tr>
		
		<tr>
            <td>Описание</td>
            <td><input type="text" name="description"/></td>
        </tr>
		
		<tr>
            <td>Бюджетен код</td>
            <td><input type="text" name="budget"/></td>
        </tr>

		
        <tr>
            <td colspan="2" class="text-center">
                <button class="button">Save</button>
                <button class="button" type="button" onclick="history.back()">Back</button>
            </td>
        </tr>
    </table>
</form>
</div>
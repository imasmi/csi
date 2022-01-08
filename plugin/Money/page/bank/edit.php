<?php 
include_once(\system\Core::doc_root() . '/system/php/Form.php');
$select = $PDO->query("SELECT * FROM bank WHERE id='" . $_GET["id"] . "'")->fetch();
$units = array();
foreach($PDO->query("SELECT * FROM bank_units ORDER by id ASC") as $unit){
    $units[$unit["id"]] = $unit["name"];
}
?>
<div class="admin">
<div class="title">Добавяне на банова сметка: <?php echo $units[$select["bank_unit"]];?></div>
<div class="errorMessage" id="errorMessage"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>?id=<?php echo $_GET["id"];?>" method="post">
	<table class="table">
        <tr>
            <td>Банка</td>
            <td><?php \system\Form::select("bank_unit", $units, array("select" => $select["bank_unit"]));?></td>
        </tr>
        
		<tr>
            <td>IBAN</td>
            <td><input type="text" name="IBAN" value="<?php echo $select["IBAN"];?>" required /></td>
        </tr>
		
		<tr>
            <td>Описание</td>
            <td><input type="text" value="<?php echo $select["description"];?>" name="description"/></td>
        </tr>
		
		<tr>
            <td>Бюджетен код</td>
            <td><input type="text" value="<?php echo $select["budget"];?>" name="budget"/></td>
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
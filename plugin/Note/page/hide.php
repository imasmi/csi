<?php
$select = $Query->select($_GET["id"], "id", "note");
#$Query->select($value, $selector="id", $table="module", $fields="*", $delimeter="=")
?>

<div class="admin">
<table class="table">
        
    <tr>
        <td colspan="2" class="title"><?php echo (($select["hide"] === "0000-00-00 00:00:00") ? "Скриване" : "Показване отново");?>?</td>
    </tr>
    
    <tr>
		<td>Бележка</td>
        <th class="title"><?php echo $select["note"];?></th>
    </tr>
	
	<tr>
		<td>Дело</td>
        <td><?php echo $Caser->number($select["case_id"]);?></td>
    </tr>
        
    <tr>
        <td colspan="2" class="text-center">
            <?php echo $Form->deleteSubmit();?>
            <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->t("Back");?></button>
        </td>
    </tr>
</table>
</div>

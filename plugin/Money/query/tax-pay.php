<div class="csi view">
<?php
$doc = $PDO -> query("SELECT * FROM doc_types t, document d  WHERE d.name=t.id AND d.type LIKE 'outgoing' AND d.number='" . $_POST["open"] . "' ORDER by d.date DESC")->fetch();
$case = $Query->select($doc["case_id"], "id", "caser");
if(isset($_POST["debtor"]) && $_POST["debtor"] != '0'){
	$person = $PDO -> query("SELECT * FROM person WHERE id=" . $_POST["debtor"])->fetch();
}

$description_1 = explode(" - ", $doc[1]);
$description_2 = ($doc["name"] == '104' || $doc["name"] == '123') ? "ЕГН " . $person["EGN_EIK"] . " " : "";
?>
<h1><?php echo $doc[1];?></h1>
<?php $person = $PDO -> query("SELECT * FROM person WHERE id=" . $doc["sender_receiver"])->fetch();?>
<h2><?php echo $person["name"];?></h2>
<form>
	<table>
		<tr><th colspan="2" id="Theader"></th></tr>
		<?php
		$main_description = mb_convert_case($description_1[1], MB_CASE_LOWER, "UTF-8");
		$description = str_replace("искане за ", "", $main_description);
		?>
		<tr>
			<td>Пояснение: <input maxlength="35" name="Document.Description1" size="40" type="text" value="Такса за <?php echo $description;?>"></td>
			<td>Допълнително пояснение: <input maxlength="35" name="Document.Description2" size="40" type="text" value="<?php echo $description_2;?>ИД <?php echo $case["number"];?>"></td>
		</tr>

		<tr>
			<td>
				Номер на документ, по който се плаща *<br/>
				<input type="text" maxlength="17" name="Document.LiabilityDocumentNumber" size="40" value="<?php echo $doc["number"];?>">
			</td>
			<td>
				Дата на документа *<br/>
				<input type="text" name="Document.LiabilityDocumentDate" size="11" value="<?php echo date("d.m.Y", strtotime($doc["date"]));?>">
				<b style="background-color: coral">Дата на документа да оправя</b>
			</td>
		</tr>
	</table>
</form>
</div>

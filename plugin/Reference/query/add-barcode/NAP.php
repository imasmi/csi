<?php
$list = $_POST["dir"];
$listConv = iconv ( "UTF-8", "windows-1251" ,  $list );
?>
<form class="form admin" id="form" accept-charset="UTF-8" method="post" action="<?php echo $Core->this_path(0,-1);?>/place-NAP?type=<?php echo $_POST["type"];?>" target="_blank">
<input type="hidden" name="dir" value="<?php echo $list;?>"/>
<table class="listTable napReorder">
	<tr>
		<td>№</td>
		<td></td>
		<td>Файл</td>
		<td>Дело</td>
	</tr>
	<?php
	$cnt = 1;
	$bar_check = array();

	$listDir = scandir($listConv);
	unset($listDir[0], $listDir[1]);
	foreach($listDir as $f){
		$case = NULL;
		$barcode = NULL;
	?>
	<tr id="row-<?php echo $cnt;?>">
	<?php
		$folder = iconv ( "windows-1251" , "UTF-8", $f );
		$name = str_replace($list, "", $folder);

		// НАП 74
		$case_numb = explode("_", $name)[0];
		$case_id = $Query->select($case_numb, "number", $Caser->table, "id")["id"];

		$exclude = "";
		if(isset($bar_check[$case_id])){
			foreach($bar_check[$case_id] as $value){
				$exclude .= " AND id != '" . $value . "'";
			}
		}
		$barcode = $PDO->query("SELECT id, barcode FROM document WHERE case_id='" . $case_id . "' AND type='incoming'" . $exclude . " ORDER by id DESC")->fetch();
		$bar_check[$case_id][] = $barcode["id"];

	?>
		<td><?php echo $cnt;?></td>
		<td><button type="button" class="button" onclick="S.remove('#row-<?php echo $cnt;?>')">X</button></td>
		<td><input type="text" name="file_<?php echo $cnt;?>" value="<?php echo $name;?>"/></td>
		<td><?php echo $case_numb;?></td>
		<td><input type="text" name="barcode_<?php echo $cnt;?>" value="<?php echo $barcode["barcode"];?>"/></td>
	</tr>
	<?php
	$cnt++;
	} ?>
	<tr><td colspan="100%"><button class="button">Поставяне</button></td></tr>
</table>
<input type="hidden" name="rows" value="<?php echo $cnt;?>"/>
</form>

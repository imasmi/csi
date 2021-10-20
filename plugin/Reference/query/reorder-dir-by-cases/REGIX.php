<?php
$list = $_POST["dir"];
$listConv = iconv ( "UTF-8", "windows-1251" ,  $list );
?>
<form class="form" id="form" accept-charset="UTF-8" method="post" action="<?php echo $Core->this_path(0,-1);?>/rename-NAP-191" target="_blank">
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

	$listDir = scandir($listConv);
	unset($listDir[0], $listDir[1]);
	foreach($listDir as $f){
		$case = NULL;
	?>
	<tr id="row-<?php echo $cnt;?>">
	<?php
		$folder = iconv ( "windows-1251" , "UTF-8", $f );
		$name = str_replace($list, "", $folder);

    // НАП 191
		$grao = file_get_contents("file://" . $listConv . '\\' . $f);
		preg_match('/ЕГН: <\/span>(.*?)<br>/s', $grao, $matches);
		if(count($matches) > 0) {
			$egn = $matches[1];
		} else {
			preg_match('/ЕГН<\/span><span>:(.*?)<span style="font-weight:bold; ">(.*?)<\/span>/s', $grao, $matches);
			$egn = $matches[2];
		}

		$person = $Query->select(trim($egn), "EGN_EIK", "person", "id");
		$case = $PDO->query('SELECT case_id FROM caser_title WHERE debtor LIKE \'%"' . $person["id"] . '"%\' ORDER by case_id DESC')->fetch();
	?>
		<td><?php echo $cnt;?></td>
		<td><button type="button" class="button" onclick="S.remove('#row-<?php echo $cnt;?>')">X</button></td>
		<td><input type="text" name="file_<?php echo $cnt;?>" value="<?php echo $name;?>"/></td>
		<td><?php $Caser->select("case_" . $cnt, array("id" => $case["case_id"]));?></td>
	</tr>
	<?php
	$cnt++;
	} ?>
	<tr><td colspan="100%"><button class="button">Преименуване</button></td></tr>
</table>
<input type="hidden" name="rows" value="<?php echo $cnt;?>"/>
</form>

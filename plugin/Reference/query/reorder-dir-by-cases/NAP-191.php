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
		$doc_191 = file_get_contents("file://" . $listConv . '\\' . $f);
		$extension = pathinfo("file://" . $listConv . '\\' . $f)["extension"];

		if($extension == "doc"){
			$doc_191 = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$doc_191);
		} elseif($extension == "docx"){
			$Ms_office = new \plugin\Document\php\Microsoft_office($list . '\\' . $f);
			$doc_191 = $Ms_office->_();
		}

		foreach(explode(" ", $doc_191) as $value){
			if(strpos($value, "88204") !== false){
				$case = $PDO->query("SELECT id, number FROM caser WHERE number='" . substr($value, 0, 14 ) . "'")->fetch();
				break;
			}
		}

	?>
		<td><?php echo $cnt;?></td>
		<td><button type="button" class="button" onclick="S.remove('#row-<?php echo $cnt;?>')">X</button></td>
		<td><input type="text" name="file_<?php echo $cnt;?>" value="<?php echo $name;?>"/></td>
		<td><?php $Caser->select("case_" . $cnt, array("number" => $case["number"]));?></td>
	</tr>
	<?php
	$cnt++;
	} ?>
	<tr><td colspan="100%"><button class="button">Преименуване</button></td></tr>
</table>
<input type="hidden" name="rows" value="<?php echo $cnt;?>"/>
</form>

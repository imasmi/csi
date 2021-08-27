<div class="csi admin">
<?php
$caser = array();
$errors = array();
$spravki = array("НАП" => "nap","ГРАО" => "grao","НОИ" => "noi","БНБ" => "bnb");

for($a = 1; $a <= $_POST["redove"]; $a++){
	if($_POST["case_" . $a] != ""){
		if($Query->select($_POST["case_" . $a], "id", "caser") == true){
			foreach($spravki as $spravka){
				if(isset($_POST[$spravka . "_" . $a]) || ($spravka == "nap" && $_POST["nap_type_" . $a] != "0")){ $caser[$spravka][$Query->select($_POST["case_" . $a], "id", "caser", "number")["number"]] = $_POST["case_" . $a]; }
			}
			if($_POST["nap_type_" . $a] != "0"){ $_POST["nap_type_" . $_POST["case_" . $a]] = $_POST["nap_type_" . $a];}
		} else {
			$errors[] = $_POST["case_" . $a];
		}
	}
}

if(!empty($errors)){ ?>
<div class="errorLine title">Грешки</div>
	<?php foreach($errors as $error){ ?>
		<div class="title color2bg"><?php echo $error;?></div>
	<?php } ?>
<?php } ?>

<table class="listTable requestChange fullscreen" border="1px">
	<tr>
	<?php foreach($spravki as $key => $spravka){
	$class = ($spravka == "nap") ? 'class="color1bg"' : "";?>
		<td id="<?php echo $spravka;?>_button" onclick="csi.requestChange('<?php echo $spravka;?>')" <?php echo $class;?>><?php echo $key;?></td>
	<?php }?>
	</tr>
</table>


<?php
foreach($spravki as $key => $spravka){
if(!empty($caser[$spravka])){
ksort($caser[$spravka]);
$class = ($spravka != "nap") ? ' hidden' : "";
?>
<div id="<?php echo $spravka;?>" class="spravki<?php echo $class;?>">
	<h3 class="title text-center"><?php echo $key;?></h3>
	<?php
		$Reference = new \plugin\Reference\php\Reference;
		$Reference->starters($caser[$spravka]);?>
</div>
<?php }} ?>
</div>

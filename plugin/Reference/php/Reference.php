<?php
namespace plugin\Reference\php;
use \system\module\Setting\php\Setting as Setting;

class Reference{
    public function __construct($id=false){
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $Page;
        $this->Page = $Page;
        global $User;
        $this->User = $User;
        global $Setting;
        $this->Setting = $Setting;
	global $Caser;
	$this->Caser = $Caser;
	global $Note;
	$this->Note = $Note;
	$this->Bnb = new Bnb;
        $this->tag = "reference"; //Database tag for page table
        $this->plugin = "Reference"; //Full name of the plugin
        $this->link_id = 0;
	$this->id = $id;
    }

	public function starters($caser){
		?>
		<form method="post" action="<?php echo $this->Bnb->refLink();?>">
			<table class="listTable" border="1px">
				<tr>
					<th></th>
					<th>№</th>
					<th>Дела (Брой: <?php echo count($caser);?>)</th>
					<th>Егн</th>
					<th><input type="submit" value="БНБ"/></th>
					<th>
						Нап
						<select onchange="var val = this.value; S.all('.nap_starter', function(el){el.value=val;}); ">
							<option value="0">ВСИЧКИ</option>
							<option value="191">ДОПК 191</option>
							<option value="74">Член 74</option>
						</select>
					</th>
					<th>Име</th>
					<th>Дата изп.титул</th>
					<th>Известия</th>
				</tr>

			<?php
				$a = 1;
				foreach($caser as $case_id){
				$case = $this->Query->select($case_id, "id", "caser");
				$Caser = new \plugin\Caser\php\Caser($case["id"]);
				foreach ($Caser->debtor as $person){
				$pers = $this->Query->select($person, "id", "person");

				if(strpos($pers["name"], "ПОЧИНАЛ") === false){
					$rowNumb = $a . "_" . rand();
					$title_date = $Caser->title_main["date"];
					$caseActive = ($case["status"] == "ВИСЯЩО" || $case["status"] == "ВЪЗОБНОВЕНО") ? true : false;
			?>
				<tr id="spravka<?php echo $rowNumb;?>">
					<td><button type="button" onclick="$('#spravka<?php echo $rowNumb;?> #bnb_<?php echo $pers["EGN_EIK"];?>').prop('checked', false); S.hide('#spravka<?php echo $rowNumb;?>'); S('#startovi_<?php echo $case_id;?>').value=0; S.remove('#output_<?php echo $case_id;?>');">-</button></td>
					<td><?php echo $a;?></td>
					<td <?php echo ($caseActive) ? '' : 'class="color-2"';?>><?php echo $case["number"];?><?php echo ($caseActive) ? '' : '<br/>(' . $case["status"] . ')';?></td>
					<td <?php if($pers["EGN_EIK"] <= "5600000000" && substr($pers["EGN_EIK"], 0, 1) > "1" && $pers["type"] == "person"){ echo 'class="color-3-bg"';} elseif($pers["type"] == "firm"){echo 'class="color-2-bg"';}?>><?php echo $pers["EGN_EIK"];?></td>
					<td><?php echo $this->Bnb->checkbox($pers, $case["id"], true);?></td>
					<td><?php $this->nap_link($pers["id"], $case["id"], (isset($_POST["nap_type_" . $case_id]) ? $_POST["nap_type_" . $case_id] : false));?></td>
					<td>
            <?php echo $pers["name"];?>
            <br>
            <a href="<?php echo $this->Core->url();?>Reference/noi?case=<?php echo $case["id"];?>&person=<?php echo $pers["id"];?>&type=0" class="getNap" target="_blank">Трудови договори</a>
          </td>
					<td <?php if($title_date == "0000-00-00"){ echo 'class="color-2-bg"';}?>><input type="text" onchange="csi.changeDate(this);S.post('<?php echo $this->Core->url();?>Reference/query/title_date', {title: <?php echo $Caser->title_main["id"];?>, title_date: this.value})" value="<?php echo $title_date;?>"/></td>
					<td id="notes<?php echo $case["id"];?>"><?php $this->Note->_(" WHERE case_id=" . $case["id"] . " AND spravki=1 AND hide is NULL", $case["id"], "spravki", "#notes" . $case["id"]);?></td>
				</tr>
			<?php $a++; }}}?>
			</table>
			</form>
		<div id="titul"></div>
		<?php if($_GET["url"] == "spravki/startovi"){?>
		<form method="post" action="<?php echo $this->Core->url();?>query/spravki/remove_from_startovi" onsubmit="return confirm('Искате ли да премахнете тези дела от стартови справки?') == true ? true : false;">
			<?php
		}
			$this->massout($caser);
			?>
		<?php if($_GET["url"] == "spravki/startovi"){?>
			<button class="button center block margin-20">Премахни от стартови</button>
		</form>
		<?php
		}
	}

	public function massOut($caser){
		$out = array();
		foreach($caser as $case_id){
			$case = $this->Query->select($case_id, "id", "caser");
			?>
			<?php if($_GET["url"] == "spravki/startovi"){?><input name="<?php echo $case_id;?>" id="startovi_<?php echo $case_id;?>" type="hidden" value="1"/><?php } ?>
			<?php
			$numb = $this->Caser->split_number($case["number"]);
			if(!isset($out[$numb["year"]]) || !in_array($numb["number"], $out[$numb["year"]])){$out[$numb["year"]][] = '<span id="output_' . $case_id . '">' . $numb["number"] . ',</span>';}

		}

		?>

		<table class="listTable" border="1px">
			<tr>
				<th>Година</th>
				<th>Дела за изх. регистър</th>
			</tr>
			<?php foreach($out as $year=>$value){

			?>
			<tr>
				<td><?php echo $year;?></td>
				<td><?php echo implode("", $value);?></td>
			</tr>
			<?php } ?>
		</table>
		<?php
	}

	public function nap_link($person_id, $case_id, $type=false){
			$typeN = $person_id . "_" . $case_id;
		?>
			<select id="<?php echo $typeN;?>" class="nap_starter" name="<?php echo $typeN;?>">
				<option value="0">ВСИЧКИ</option>
				<option value="191" <?php if($type == 191){ echo 'selected';}?>>ДОПК 191</option>
				<option value="74" <?php if($type == 74){ echo 'selected';}?>>Член 74</option>
			</select>
			<a href="" onclick="event.preventDefault(); window.open('<?php echo $this->Core->url();?>Reference/nap?case=<?php echo $case_id;?>&person=<?php echo $person_id;?>&type=' + document.getElementById('<?php echo $typeN;?>').value, 'blank'); " class="getNap bnbCheckbox">ИЗВАДИ НАП</a>
      <?php
  }
}
?>

<?php
namespace plugin\Caser;
include_once(\system\Core::doc_root() . '/plugin/Reference/php/Bnb.php');
include_once(\system\Core::doc_root() . '/plugin/Person/php/Person.php');
include_once(\system\Core::doc_root() . '/web/php/dates.php');
use \module\Setting\Setting as Setting;

class Title{
    public function __construct($id=0, $array=array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Page;
        $this->Page = $Page;
        global $User;
        $this->User = $User;
        global $Setting;
        $this->Setting = $Setting;
        $this->table = "caser_title";
        $this->plugin = "Caser"; //Full name of the plugin
        $this->link_id = 0;
		$this->id = $id;
		$this->item = $PDO->query("SELECT * FROM " . $this->table . " WHERE id='" . $id . "'")->fetch();
		$this->case = $PDO->query("SELECT * FROM caser WHERE id='" . $this->item["case_id"] . "'")->fetch();
		$this->type = $this->PDO->query("SELECT value FROM " . $Setting->table . " WHERE id='" . $this->item["type"] . "'")->fetch()["value"];
	}

	public function date(){
		if((strpos($this->item["type"], "Акт за уст. на публично вземане") !== false || strpos($this->item["type"], "Акт по чл.106/107 от ДОПК") !== false) && $this->item["date"] == "0000-00-00"){
			$nd = explode("/", $this->item["case"]);
			$titul_date = date("Y-m-d", strtotime($nd[1]));
		} else {
			$titul_date = $this->item["date"];
		}
		return $titul_date;
	}

	public function data () {
	?>
		<div>Съд: <?php echo $this->item["court_id"] != 0 ? $this->PDO->query("SELECT name FROM person WHERE id='" . $this->item["court_id"] . "'")->fetch()["name"] : $this->item["court"];?></div>
		<div>Тип: <?php echo $this->type;?></div>
		<div>Номер: <?php echo $this->item["number"];?></div>
		<div class="margin-bottom-10">Дата: <?php echo \web\dates::_($this->item["date"]);?></div>
		<a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/edit?id=<?php echo $this->id;?>" title="Редакция на титул"><?php echo $GLOBALS["Font_awesome"]->_("Edit icon");?></a>
	<?php
	}

	public function creditors(){
		$creditor_data = json_decode($this->item["creditor"]);
		if (is_array($creditor_data)) {
			foreach (json_decode($this->item["creditor"]) as $person){
			$pers = $this->PDO->query("SELECT * FROM person WHERE id='" . $person . "'")->fetch();
			$Person = new \plugin\Person\Person($pers["id"]);
			?>
				<b class="color-6"><?php echo $pers["name"];?></b>
				<br/>
				<?php echo $this->pType($pers);?> <?php echo $pers["EGN_EIK"];?>
				<div class="marginY-10">
					<?php echo $Person->edit();?>
					<a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/change-person?id=<?php echo $this->id;?>&type=creditor&person=<?php echo $pers["id"];?>"><?php echo $GLOBALS["Font_awesome"]->_("Change icon");?></a>
				</div>
			<?php
			}
		}
	}

	public function debtors($nap=false, $bank=false){
		$Bnb = new \plugin\Reference\Bnb;
		$debtor_data = json_decode($this->item["debtor"]);
		if (is_array($debtor_data)) {
			foreach (json_decode($this->item["debtor"]) as $person){
			$pers = $this->PDO->query("SELECT * FROM person WHERE id='" . $person . "'")->fetch();
			$Person = new \plugin\Person\Person($pers["id"]);
			?>
				<b class="color-2"><?php echo $pers["name"];?></b>
				<?php if($bank !== false){ echo $Bnb->checkbox($pers, $this->case["id"]);} ?>
				<br/><?php echo $this->pType($pers);?> <?php echo $pers["EGN_EIK"];?><br/>
				<?php if($nap !== false){ $this->nap($pers["id"], $this->case["id"]);} ?>
				<div class="marginY-10">
					<?php echo $Person->edit();?>
					<a class="button button-icon" href="<?php echo \system\Core::this_path(0, -1);?>/caser_title/change-person?id=<?php echo $this->id;?>&type=debtor&person=<?php echo $pers["id"];?>&debtor"><?php echo $GLOBALS["Font_awesome"]->_("Change icon");?></a>
					<a class="button button-icon" href="<?php echo \system\Core::url();?>Money/tax/add?caser_id=<?php echo $this->case["id"];?>&title_id=<?php echo $this->id;?>&debtor_id=<?php echo $pers["id"];?>"><?php echo $GLOBALS["Font_awesome"]->_("Tax icon");?></a>
				</div>
			<?php 
			}
		}
		
	}

	public function pType($person){
		return ($person["type"] == "person") ? "ЕГН" : "ЕИК";
	}
}
?>

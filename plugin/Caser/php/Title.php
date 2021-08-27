<?php
namespace plugin\Caser\php;
use \system\module\Setting\php\Setting as Setting;

class Title{
    public function __construct($id=0, $array=array()){
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
        $this->table = "caser_title";
        $this->plugin = "Caser"; //Full name of the plugin
        $this->link_id = 0;
	$this->id = $id;
	$this->item = $Query->select($id, "id", $this->table);
	$this->case = $Query->select($this->item["case_id"], "id", "cases");
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

	public function creditors(){
		foreach (json_decode($this->item["creditor"]) as $person){
		$pers = $this->Query->select($person, "id", "person");
		$Person = new \plugin\Person\php\Person($pers["id"]);
		?>
			<b><?php echo $pers["name"];?></b>
			<br/>
			<?php echo $this->pType($pers);?> <?php echo $pers["EGN_EIK"];?>
			<div><?php echo $Person->edit();?></div>
			<br/>
			<br/>
		<?php }
	}

	public function debtors($nap=false, $bank=false){
		$Bnb = new \plugin\Reference\php\Bnb;
		foreach (json_decode($this->item["debtor"]) as $person){
		$pers = $this->Query->select($person, "id", "person");
		$Person = new \plugin\Person\php\Person($pers["id"]);
		?>
			<b><?php echo $pers["name"];?></b>
			<?php if($bank !== false){ echo $Bnb->checkbox($pers, $this->case["id"]);} ?>
			<br/><?php echo $this->pType($pers);?> <?php echo $pers["EGN_EIK"];?><br/>
			<?php if($nap !== false){ $this->nap($pers["id"], $this->case["id"]);} ?>
			<br/><br/>
			<div><?php echo $Person->edit();?></div>
		<?php }
	}

	public function pType($person){
		return ($person["type"] == "person") ? "ЕГН" : "ЕИК";
	}
}
?>

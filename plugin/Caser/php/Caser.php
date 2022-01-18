<?php
namespace plugin\Caser;
use \module\Setting\Setting as Setting;

class Caser{
    public function __construct($id=0, $array=array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Page;
        $this->Page = $Page;
        global $User;
        $this->User = $User;
        global $Setting;
        $this->Setting = $Setting;
        $this->table = "caser";
        $this->plugin = "Caser"; //Full name of the plugin
        $this->link_id = 0;
		$this->id = $id;
		if($this->id != 0){
			$this->item = $PDO->query("SELECT * FROM " . $this->table . " WHERE id='" . $id ."'")->fetch();
			$this->number = $this->item["number"];
			$this->title_main = false; // this is also set up in $this->title() function
			$this->title = $this->title();
			$this->creditor = $this->creditor();		
			$this->debtor = $this->debtor();
			$this->charger = $this->PDO->query("SELECT email FROM " . $this->User->table . " WHERE id='" . $this->item["charger"] . "'")->fetch()["email"];
			$this->status = $this->Setting->_($this->item["status"]);
			$this->color = $this->Setting->_($this->item["status"], ["column" => "type"]);
			$this->statistic = $this->Setting->_("statistic-" . $this->item["statistic"]);
		} else {
			$this->number = "";
			$this->color = "";
		}
    }

// Static functions 
	
	public static function status(){
		$status = [];
		foreach ($GLOBALS["Setting"]->items as $key => $value){
			if ($value["tag"] == "status" && $value["plugin"] == "Caser") {
				$status[$value["value"]] = $key;
			}
		}
		return $status;
	}

	public static function number($year, $number){
		return $year . (8820400000 + $number);
	}

	public static function split_number($number){
		$year = substr($number, 0, 4);
		$cnumb = substr($number, -5);
		return array("year" => $year, "number" => ltrim($cnumb, "0"));
	}

	public static function short_number($number){
		$split = static::split_number($number);
		return $split["number"] . '/' . $split["year"];
	}

	public static function type(){
		return array(
			1000 => "ОБЩО /ш. 1000 = 1100 + 1200 + 1300 + 1400/", 
			1100 => "І. В ПОЛЗА НА ДЪРЖАВАТА  И ОБЩИНИТЕ /ш. 1100 = 1110+1140+1170/", 
			1110 => "1.В ПОЛЗА НА ДЪРЖАВНИ ОРГАНИ /ш.1110=1120+1130/ в т. ч.", 
			1120 => "а/ публични държавни вземания", 
			1130 => "б/ частни вземания", 
			1140 => "2. В ПОЛЗА НА ОБЩИНИТЕ /ш.1140 = 1150+1160/ в т. Ч.", 
			1150 => "а/ публични вземания ", 
			1160 => "б/ частни вземания", 
			1170 => "3. В ПОЛЗА НА СЪДИЛИЩАТА", 
			1200 => "II. В ПОЛЗА НА ЮРИДИЧЕСКИ ЛИЦА И ТЪРГОВЦИ /ш. 1200 = 1210+1220+1230/ в т.ч.",
			1210 => "а/ в полза на банки", 
			1220 => "б/ в полза на търговци", 
			1230 => "в/ в полза на други ЮЛ", 
			1300 => "ІІІ. В ПОЛЗА НА ГРАЖДАНИ /ш.1300 = ш.1310+1320+1330+1340/ в т. ч.", 
			1310 => "а/ за издръжки", 
			1320 => "б/ по трудови спорове", 
			1330 => "в/ предаване на дете", 
			1340 => "г/ други", 
			1400 => "ІV. ИЗПЪЛНЕНИЕ НА ЧУЖДЕСТРАННИ РЕШЕНИЯ ", 
			1500 => "V. ИЗПЪЛНЕНИЕ НА ОБЕЗПЕЧИТЕЛНИ МЕРКИ ");
	}

	public static function years(){
		$array = array();
		for($a = date("Y"); $a > 2012; $a--){
			$array[] = $a;
		}
		return $array;
	}
	
	//Array possible values:
	//id => int (ид на дело)
	//number => string (номер на дело)
	//search => string (текст от който да се търси възможно дело)
	public function select($name, $array = array()){
		if(isset($array["id"])){
			$caser = $this->PDO->query("SELECT id, number FROM caser WHERE id='" . $array["id"] . "'")->fetch();
		} else if (isset($array["number"])){
			$caser = $this->PDO->query("SELECT id, number FROM caser WHERE number='" . $array["number"] . "'")->fetch();
		} else if(isset($array["search"])){
			$numbers = preg_replace("/[^0-9\/\s+]+/", "", $array["search"]);
			$search = explode(" ", $numbers);
			foreach($search as $key => $needle){if(trim($needle) == "" || $needle == "/"){unset($search[$key]);}}
			foreach($search as $needle){
				if(is_numeric($needle) && strlen($needle) == 14){
					$check = $this->PDO->query("SELECT id, number FROM caser WHERE number='" . $needle . "'");
					if($check->rowCount() == 1){$caser = $check->fetch();break;}
				} elseif(strpos($needle, "/") !== false){
					$part = explode("/", $needle);
					$part[1] = strlen($part[1]) == 2 ? "20" . $part[1] : $part[1];
					$check = $this->PDO->query("SELECT id, number FROM caser WHERE number='" . $part[1] . (8820400000 + $part[0]) ."'");
					if($check->rowCount() == 1){$caser = $check->fetch();break;}
				} elseif(is_numeric($needle) && (strlen($needle) == 9 || strlen($needle) == 10)){
					$person = $this->PDO->query("SELECT id FROM person WHERE EGN_EIK='" . $needle . "'");
					if($person->rowCount() > 0){
						$check = $this->PDO->query("SELECT case_id FROM caser_title WHERE debtor LIKE '%" . $person->fetch()["id"] . "%'");
						if($check->rowCount() == 1){ $caser = $this->PDO->query("SELECT id, number FROM caser WHERE id='" . $check->fetch()["case_id"] . "'")->fetch(); break;}
					}
				}
			}
		} else if ( $this->id != 0 ) {
			$caser = $this->item;
		}
	?>
		<div class="selector">
			<input type="hidden" name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php if(isset($caser)){ echo $caser["id"];}?>"/>
			<input type="text" autocomplete="off" id="<?php echo $name;?>-data" onkeyup="csi.trim(this);S.post('<?php echo \system\Core::url() . $this->plugin;?>/query/selector', {data: this.value, id: '<?php echo $name;?>'}, '#<?php echo $name;?>-list', true)" value="<?php if(isset($caser)){ echo $caser["number"];}?>"/>
			<div id="<?php echo $name;?>-list" class="select-list"></div>
		</div>
	<?php
	}

	public function open(){
		?>
		<a href="<?php echo \system\Core::url() . "Caser/open?id=" . $this->id;?>"  class="caser-number <?php echo $this->color;?>" target="_blank"><?php echo $this->number;?></a>
		<?php
	}

	public function title($id=false){
		$id = $id !== false ? $id : $this->id;
		$items = array();
		$a = 0;
		foreach($this->PDO->query("SELECT * FROM " . $this->table . "_title WHERE case_id = " . $this->id . " AND deleted IS NULL ORDER by id ASC") as $title){
		    $items[$title["id"]] = $title;
			if ($a == 0){$this->title_main = $title;}
			++$a;
		}
		return $items;
	}

	public function debtor($id=false){
		$titles = $id !== false ? $this->title($id) : $this->title;
		$debtors = array();	
		foreach($titles as $title){
			$debtor_data = json_decode($title["debtor"]);
			if (is_array($debtor_data )) {
				foreach($debtor_data as $debtor){
					$debtors[] = $debtor;
				}
			}
		}
		return $debtors;
	}

	public function creditor($id=false){
		$titles = $id !== false ? $this->title($id) : $this->title;
		$creditors = array();	
		foreach($titles as $title){
			$creditor_data = json_decode($title["creditor"]);
			if (is_array($creditor_data )) {
				foreach($creditor_data as $creditor){
					$creditors[] = $creditor;			
				}
			}
		}
		return $creditors;
	}
}
?>

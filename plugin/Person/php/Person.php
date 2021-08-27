<?php
namespace plugin\Person\php;
use \system\module\Setting\php\Setting as Setting;

class Person{
	// array("type" => creditor|debtor)
	public function __construct($id=false, $array = array()){
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
		$this->table = "person";
		$this->plugin = "Person"; //Full name of the plugin
		$this->id = $id;
		$this->item = $Query->select($id, "id", $this->table);
		$this->name = $this->item["name"];
		$this->type = $this->item["type"];
		$this->type_name = $this->type == "person" ? "ЕГН" : "ЕИК";
	}
	
	//Array possible values:
	//id => int (ИД на лице)
	//name => string (Име на лице)
	public function select($name, $array = array()){
		if(isset($array["id"]) || $this->id !== false){
			$person = $this->PDO->query("SELECT id, name FROM person WHERE id='" . (isset($array["id"]) ? $array["id"] : $this->id) . "'")->fetch();
		} elseif(isset($array["name"])){
			$person = $this->PDO->query("SELECT id, name FROM person WHERE name='" . $array["name"] . "'")->fetch();
		}
	?>
		<div class="selector">
			<input type="hidden" name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php if(isset($person)){ echo $person["id"];}?>"/>
			<input type="text" autocomplete="off" id="<?php echo $name;?>-data" onkeyup="S.post('<?php echo $this->Core->url() . $this->plugin;?>/query/selector', {data: this.value, id: '<?php echo $name;?>'}, '#<?php echo $name;?>-list', true)" value="<?php if(isset($person)){ echo $person["name"];}?>"/>
			<div id="<?php echo $name;?>-list" class="select-list"></div>
		</div>
	<?php
	}

	public function edit(){
		?>
			<button class="button" onclick="window.open('<?php echo $this->Core->url();?>other/person/edit?id=<?php echo $this->id;?>', '_self')">Edit</button>
			<button class="button" onclick="window.open('<?php echo $this->Core->url();?>other/person/bank?id=<?php echo $this->id;?>', '_self')">Banks</button>
		<?php
	}

	public function _(){
		?>
			<div class="text-center">
				<b><?php echo $this->name;?></b>
				<div><?php echo $this->type_name;?> <?php echo $this->item["EGN_EIK"];?></div>
			</div>
		<?php
	}
}
?>
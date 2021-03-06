<?php
namespace plugin\Document;
include_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');

use \module\Setting\Setting as Setting;
use \plugin\Caser\Caser as Caser;

class Document{
	public function __construct($case_id=false){
		global $PDO;
		$this->PDO = $PDO;
		global $Page;
		$this->Page = $Page;
		global $User;
		$this->User = $User;
		global $Setting;
		$this->Setting = $Setting;
		$this->table = "document";
		$this->plugin = "Document"; //Full name of the plugin
		$this->link_id = 0;
		$this->case_id = $case_id;
		$this->ListingAPP = new \module\Listing\ListingAPP;
		$this->openODT = "openODT://";
		//$this->url = "C:/Users/1/Downloads/enforcer_documents/share-proxy/d55b818538c9ee4c953c9e6f61610d7e-symfony/";
		$this->url = "D:/enforcer_documents/share-proxy/d55b818538c9ee4c953c9e6f61610d7e-symfony/";
		$this->types = [
			"incoming" => "Входящ",
			"outgoing" => "Изходящ",
			"protocol" => "Протокол",
		];
	}

	public function add_button($type){
		?>
			<a class="button" href="<?php echo \system\Core::url();?>Document/add?type=<?php echo $type; if ($this->case_id) { echo '&case_id=' . $this->case_id;}?>"><?php echo $GLOBALS["Font_awesome"]->_("Add icon");?></a>
		<?php
	}

	public function edit_button($id){
		?>
			<a class="button button-icon" href="<?php echo \system\Core::url();?>Document/edit?id=<?php echo $id?>"><?php echo $GLOBALS["Font_awesome"]->_("Edit icon");?></a>
		<?php
	}

	public function incoming(){
	?>
		<div class="admin">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $this->add_button("incoming");?></th>
					<th>Вх. номер</th>
					<?php if(!$this->case_id){?><th>Дело</th><?php } ?>
					<th>Длъжник</th>
					<th class="iban">RegiX</th>
					<th>Дата на входиране</th>
					<th>Подател</th>
					<th>Описание</th>
					<th>Бележка</th>
					<th>Входирал</th>
					<?php if(!$this->case_id){?>
					<th>
						<select onchange="window.open('<?php echo $this->ListingAPP->replace_get(array("charger" => "' + this.value + '" ));?>', '_self')">
							<option value="all">Всички</option>
							<?php 
								foreach($this->PDO->query("SELECT * FROM " . $this->User->table . " WHERE status='active' ORDER by email ASC") as $charger){
								?>
								<option value="<?php echo $charger["id"];?>" <?php if(isset($_GET["charger"]) && $_GET["charger"] == $charger["id"] || (!isset($_GET["charger"]) && ($this->User->group("пчси") || $this->User->group("деловодител")) && $this->User->id == $charger["id"])){ echo 'selected';}?>><?php echo $charger["email"];?></option>
								<?php
								}							
							?>
						</select>
					</th>
					<?php } ?>
				</tr>
				
				<?php
				$incomings = array();
				$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : "");
				$case_id = $this->case_id ? " AND case_id='" . $this->case_id . "'" : "";
				$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
				foreach($this->PDO->query("SELECT * FROM document WHERE type='incoming' " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, number DESC") as $incoming){
					$incomings[] = $incoming;
					/*
					$Caser = new Caser($incoming["case_id"]);
					if($charger !== false){
						if($_GET["charger"] == $Caser->charger){$incomings[] = $incoming;}
					} else {
						if($this->User->group("пчси")  || $this->User->group("деловодител")){ 
							if($this->User->id == $Caser->charger){$incomings[] = $incoming;}
						} else {
							$incomings[] = $incoming;	
						}
					}
					*/
				}

				foreach(( $this->case_id ? $incomings : $this->ListingAPP->page_slice($incomings) ) as $incoming){
				$Caser = new Caser($incoming["case_id"]);
				$incomeDate = date("d.m.Y", strtotime($incoming["date"]));
				?>
				<tr>
					<td><?php echo $this->edit_button($incoming["id"]);?></td>
					<td><?php echo  $incoming["number"];?></td>
					<?php if(!$this->case_id){?><td><?php $Caser->open();?></td><?php } ?>
					<td><?php if ($incoming["person"] != 0) { echo $this->PDO->query("SELECT name FROM person WHERE id='" . $incoming["person"] . "'")->fetch()["name"];}?></td>
					<td>Вх. № <?php echo  $incoming["number"] . '/' . $incomeDate;?></td>
					<td><?php echo  $incomeDate;?></td>
					<td><?php echo  $this->PDO->query("SELECT name FROM person WHERE id='" .$incoming["sender_receiver"] . "'")->fetch()["name"];?></td>
					<td><?php echo  $this->PDO->query("SELECT name FROM doc_types WHERE id='" . $incoming["name"] . "'")->fetch()["name"];?></td>
					<td><?php echo  $incoming["note"];?></td>
					<td><?php echo  $this->User->item($incoming["user"])["email"];?></td>
					<?php if(!$this->case_id){?><td><?php echo  $this->User->item($Caser->charger)["email"];?></td><?php } ?>
				</tr>	
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($incomings));}?>
		</div>
	<?php
	}

	public function outgoing(){
	?>
		<div class="admin">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $this->add_button("outgoing");?></th>
						<th></th>
						<th>Изх. номер</th>
						<?php if(!$this->case_id){?><th>Дело</th><?php } ?>
						<th>Длъжници</th>
						<th>Дата на изходиране</th>
						<th>Адресат</th>
						<th>Описание</th>
						<th>Бележка</th>
						<th>Изходирал</th>
						<?php if(!$this->case_id){?>
						<th>
							<select onchange="window.open('<?php echo $this->ListingAPP->replace_get(array("charger" => "' + this.value + '" ));?>', '_self')">
								<option value="all">Всички</option>
								<?php 
									foreach($this->PDO->query("SELECT * FROM " . $this->User->table . " WHERE status='active' ORDER by email ASC") as $charger){
									?>
									<option value="<?php echo $charger["id"];?>" <?php if(isset($_GET["charger"]) && $_GET["charger"] == $charger["id"] || (!isset($_GET["charger"]) && ($this->User->group("пчси") || $this->User->group("деловодител")) && $this->User->id == $charger["id"])){ echo 'selected';}?>><?php echo $charger["email"];?></option>
									<?php
									}							
								?>
							</select>					
						</th>
						<?php } ?>
					</tr>
					
					<?php 

					$outgoings = array();
						$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : "");
						$case_id = $this->case_id ? " AND case_id='" . $this->case_id . "'" : "";
						$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
						
						foreach($this->PDO->query("SELECT * FROM document WHERE type='outgoing' " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, number DESC") as $outgoing){
							$outgoings[] = $outgoing;
							/*
							$Caser = new Caser($outgoing["case_id"]);
							if($charger !== false){
								if($_GET["charger"] == $Caser->charger){$outgoings[] = $outgoing;}
							} else {
								if($this->User->group("пчси")  || $this->User->group("деловодител")){ 
									if($this->User->id == $Caser->charger){$outgoings[] = $outgoing;}
								} else {
									$outgoings[] = $outgoing;	
								}
							}
							*/
						}
						foreach(( $this->case_id ? $outgoings : $this->ListingAPP->page_slice($outgoings) ) as $outgoing){
						$Caser = new Caser($outgoing["case_id"]);
						$outgoing_name = $this->PDO->query("SELECT name FROM doc_types WHERE id='" . $outgoing["name"] . "'")->fetch()["name"];
						$outgoin_date = date("d.m.Y", strtotime($outgoing["date"]));
						$split_number = $Caser->split_number($Caser->number);
						$outgoing_file = $this->url . $split_number["year"] . "/" . sprintf("%05d", $split_number["number"]). "/". $outgoing["number"] . ' от ' . $outgoin_date . ' ' . $outgoing_name . '.odt';
					?>
					<tr>
						<td><?php echo $this->edit_button($outgoing["id"]);?></td>
						<td>
							<?php 
								if (file_exists(iconv( "UTF-8", "windows-1251" , $outgoing_file))) {?>
									<a href="<?php echo $this->openODT . $outgoing_file;?>" class="button">Отвори</a>
								<?php } else if ($outgoing["template"] != 0) {?>
									<a href="<?php echo \system\Core::url();?>Document/query/document-template-create?id=<?php echo $outgoing["id"];?>&path=<?php echo $outgoing_file;?>" class="button">Създай</a>
								<?php } ?>
						</td>
						<td><?php echo $outgoing["number"];?></td>
						<?php if(!$this->case_id){?><td><?php $Caser->open();?></td><?php } ?>
						<td>
						<?php
						if(isset($case["debtors"])){
							foreach ($Caser->debtor as $person){
								$pers = $PDO -> query("SELECT * FROM person WHERE id = " . $person)->fetch();
								if($pers["type"] == "person"){ 
									$type = 'ЕГН';
									$bnb_code = 100;
								} else { 
									$type = 'ЕИК';
									$bnb_code = 200;
								}
						?>
								<b><?php echo  $pers["name"];?></b>
								<br/><?php echo  $type;?> <?php echo $pers["EGN_EIK"];?><br/>
								<br/>
						<?php }} ?>
						</td>
						<td><?php echo  date("d.m.Y", strtotime($outgoing["date"]));?></td>
						<td><?php echo  $this->PDO->query("SELECT name FROM person WHERE id='" .$outgoing["sender_receiver"] . "'")->fetch()["name"];?></td>
						<td><?php echo  $outgoing_name;?></td>
						<td><?php echo  $outgoing["note"];?></td>
						<td><?php echo  $this->User->item($outgoing["user"])["email"];?></td>
						<?php if(!$this->case_id){?><td><?php echo  $this->User->item($Caser->charger)["email"];?></td><?php } ?>
					</tr>	
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($outgoings));}?>
		</div>
	<?php	
	}

	public function protocol(){
	?>
		<div class="admin">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $this->add_button("protocol");?></th>
					<th></th>
					<th>Протокол номер</th>
					<?php if(!$this->case_id){?><th>Дело</th><?php } ?>
					<th>Дата на създаване</th>
					<th>Описание</th>
					<th>Бележка</th>
					<?php if(!$this->case_id){?>
					<th>
						<select onchange="window.open('<?php echo $this->ListingAPP->replace_get(array("charger" => "' + this.value + '" ));?>', '_self')">
							<option value="all">Всички</option>
							<?php 
								foreach($this->PDO->query("SELECT * FROM " . $this->User->table . " WHERE status='active' ORDER by email ASC") as $charger){
								?>
								<option value="<?php echo $charger["id"];?>" <?php if(isset($_GET["charger"]) && $_GET["charger"] == $charger["id"] || (!isset($_GET["charger"]) && ($this->User->group("пчси") || $this->User->group("деловодител")) && $this->User->id == $charger["id"])){ echo 'selected';}?>><?php echo $charger["email"];?></option>
								<?php
								}							
							?>
						</select>					
					</th>
					<?php } ?>
				</tr>
				
				<?php
				$protocols = array();
				$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : "");
				$case_id = $this->case_id ? " AND case_id='" . $this->case_id . "'" : "";
				$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
				foreach($this->PDO->query("SELECT * FROM document WHERE type='protocol' " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, number DESC") as $protocol){
					$protocols[] = $protocol;
					/*
					$Caser = new Caser($protocol["case_id"]);
					if($charger !== false){
						if($_GET["charger"] == $Caser->charger){$protocols[] = $protocol;}
					} else {
						if($this->User->group("пчси") || $this->User->group("деловодител")){ 
							if($this->User->id == $Caser->charger){$protocols[] = $protocol;}
						} else {
							$protocols[] = $protocol;	
						}
					}
					*/
				}
				foreach(( $this->case_id ? $protocols : $this->ListingAPP->page_slice($protocols) ) as $protocol){
				$Caser = new Caser($protocol["case_id"]);
				$incomeDate = date("d.m.Y", strtotime($protocol["date"]));
				$split_number = $Caser->split_number($Caser->number);
				$protocol_file = $this->url . $split_number["year"] . "/" . sprintf("%05d", $split_number["number"]). '/protocol-' . $protocol["number"] . '-' . $incomeDate . '.odt';
				?>
				<tr>
					<td><?php echo $this->edit_button($protocol["id"]);?></td>
					<td><?php if (file_exists($protocol_file)) {?><a href="<?php echo $this->openODT . $protocol_file;?>" class="button">Отвори</a><?php } ?></td>
					<td><?php echo  $protocol["number"];?></td>
					<td><?php $Caser->open();?></td>
					<td><?php echo  $incomeDate;?></td>
					<td><?php echo  $this->PDO->query("SELECT name FROM doc_types WHERE id='" . $protocol["name"] . "'")->fetch()["name"];?></td>
					<td><?php echo  $protocol["note"];?></td>
					<?php if(!$this->case_id){?><td><?php echo  $this->User->item($Caser->charger)["email"];?></td><?php } ?>
				</tr>	
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($protocols));}?>
		</div>
	<?php
	}
}

$Document = new Document;
?>

<?php
namespace plugin\Document\php;
use \system\module\Setting\php\Setting as Setting;
use \plugin\Caser\php\Caser as Caser;

class Document{
	public function __construct($case_id=false){
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
		$this->table = "document";
		$this->plugin = "Document"; //Full name of the plugin
		$this->link_id = 0;
		$this->case_id = $case_id;
		if($this->User->type !== "admin"){require_once($Core->doc_root() . "/system/module/Listing/php/ListingAPP.php");}
		$this->ListingAPP = new \system\module\Listing\php\ListingAPP;
	}

	public function incoming(){
	?>
		<div class="admin">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<th>Вх. номер</th>
					<?php if(!$this->case_id){?><th>Дело</th><?php } ?>
					<th>Длъжници</th>
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
								<option value="<?php echo $charger["id"];?>" <?php if($_GET["charger"] == $charger["id"] || (!isset($_GET["charger"]) && ($this->User->role == "пчси" || $this->User->role == "деловодител") && $this->User->id == $charger["id"])){ echo 'selected';}?>><?php echo $charger["email"];?></option>
								<?php
								}							
							?>
						</select>
					</th>
					<?php } ?>
				</tr>
				
				<?php
				$incomings = array();
				$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : " AND date>='" . date("Y-m-d", strtotime(" -7 days")) . "'");
				$case_id = $this->case_id ? " AND case_id='" . $this->case_id . "'" : "";
				$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
				foreach($this->PDO->query("SELECT * FROM document WHERE type='incoming' " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, number DESC") as $incoming){
					$Caser = new Caser($incoming["case_id"]);
					if($charger !== false){
						if($_GET["charger"] == $Caser->charger){$incomings[] = $incoming;}
					} else {
						if($this->User->role == "пчси" || $this->User->role == "деловодител"){ 
							if($this->User->id == $Caser->charger){$incomings[] = $incoming;}
						} else {
							$incomings[] = $incoming;	
						}
					}
				}

				foreach(( $this->case_id ? $incomings : $this->ListingAPP->page_slice($incomings) ) as $incoming){
				$Caser = new Caser($incoming["case_id"]);
				$incomeDate = date("d.m.Y", strtotime($incoming["date"]));
				?>
				<tr>
					<td><?php echo  $incoming["number"];?></td>
					<?php if(!$this->case_id){?><td><?php $Caser->open();?></td><?php } ?>
					<td>
					<?php
					if(!empty($Caser->debtor)){
						foreach ($Caser->debtor as $person){
							$pers = $this->PDO -> query("SELECT * FROM person WHERE id = " . $person)->fetch();
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
					<td>Вх. № <?php echo  $incoming["number"] . '/' . $incomeDate;?></td>
					<td><?php echo  $incomeDate;?></td>
					<td><?php echo  $this->Query->select($incoming["sender_receiver"], "id", "person", "name")["name"];?></td>
					<td><?php echo  $this->Query->select($incoming["name"], "id", "doc_types", "name")["name"];?></td>
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
									<option value="<?php echo $charger["id"];?>" <?php if($_GET["charger"] == $charger["id"] || (!isset($_GET["charger"]) && ($this->User->role == "пчси" || $this->User->role == "деловодител") && $this->User->id == $charger["id"])){ echo 'selected';}?>><?php echo $charger["email"];?></option>
									<?php
									}							
								?>
							</select>					
						</th>
						<?php } ?>
					</tr>
					
					<?php 

					$outgoings = array();
						$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : " AND date>='" . date("Y-m-d", strtotime(" -7 days")) . "'");
						$case_id = $this->case_id ? " AND case_id='" . $this->case_id . "'" : "";
						$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
						foreach($this->PDO->query("SELECT * FROM document WHERE type='outgoing' " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, number DESC") as $outgoing){
							$Caser = new Caser($outgoing["case_id"]);
							if($charger !== false){
								if($_GET["charger"] == $Caser->charger){$outgoings[] = $outgoing;}
							} else {
								if($this->User->role == "пчси" || $this->User->role == "деловодител"){ 
									if($this->User->id == $Caser->charger){$outgoings[] = $outgoing;}
								} else {
									$outgoings[] = $outgoing;	
								}
							}
						}
						foreach(( $this->case_id ? $outgoings : $this->ListingAPP->page_slice($outgoings) ) as $outgoing){
						$Caser = new Caser($outgoing["case_id"]);
					?>
					<tr>
						<td><?php echo  $outgoing["number"];?></td>
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
						<td><?php echo  $this->Query->select($outgoing["sender_receiver"], "id", "person")["name"];?></td>
						<td><?php echo  $this->Query->select( $outgoing["name"], "id", "doc_types")["name"];?></td>
						<td><?php echo  $this->outgoing["note"];?></td>
						<td><?php echo  $this->User->item($outgoing["user"])["email"];?></td>
						<?php if(!$this->case_id){?><td><?php echo  $this->User->item($Caser->charger)["email"];?></td><?php } ?>
					</tr>	
				<?php } ?>
			</table>
			<?php if(!$this->case_id){$this->ListingAPP->pagination(count($protocols));}?>
		</div>
	<?php	
	}

	public function protocol(){
	?>
		<div class="admin">
			<table class="listTable" border="1px" cellpadding="0" cellspacing="0">
				<tr>
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
								<option value="<?php echo $charger["id"];?>" <?php if($_GET["charger"] == $charger["id"] || (!isset($_GET["charger"]) && ($this->User->role == "пчси" || $this->User->role == "деловодител") && $this->User->id == $charger["id"])){ echo 'selected';}?>><?php echo $charger["email"];?></option>
								<?php
								}							
							?>
						</select>					
					</th>
					<?php } ?>
				</tr>
				
				<?php
				$protocols = array();
				$period = isset($_GET["end"]) && !empty($_GET["end"]) ? " AND date >= '" . $_GET["start"] . "' AND date <= '" . $_GET["end"] . "'" : (isset($_GET["start"]) ? " AND date='" . $_GET["start"] . "'"  : " AND date>='" . date("Y-m-d", strtotime(" -7 days")) . "'");
				$case_id = $this->case_id ? " AND case_id='" . $this->case_id . "'" : "";
				$charger = isset($_GET["charger"]) && $_GET["charger"] != "all" ? $this->User->item($_GET["charger"]) : false;
				foreach($this->PDO->query("SELECT * FROM document WHERE type='protocol' " . $case_id .  ($this->case_id ? "" : $period) . " ORDER by date DESC, number DESC") as $protocol){
					$Caser = new Caser($protocol["case_id"]);
					if($charger !== false){
						if($_GET["charger"] == $Caser->charger){$protocols[] = $protocol;}
					} else {
						if($this->User->role == "пчси" || $this->User->role == "деловодител"){ 
							if($this->User->id == $Caser->charger){$protocols[] = $protocol;}
						} else {
							$protocols[] = $protocol;	
						}
					}
				}
				foreach(( $this->case_id ? $protocols : $this->ListingAPP->page_slice($protocols) ) as $protocol){
				$Caser = new Caser($protocol["case_id"]);
				$incomeDate = date("d.m.Y", strtotime($protocol["date"]));
				?>
				<tr>
					<td><?php echo  $protocol["number"];?></td>
					<td><?php $Caser->open();?></td>
					<td><?php echo  $incomeDate;?></td>
					<td><?php echo  $this->Query->select($protocol["name"], "id", "doc_types", "name")["name"];?></td>
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

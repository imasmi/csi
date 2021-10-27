<?php
namespace plugin\Note\php;
use web\php\dates;

class Note{
	public function __construct(){
		global $PDO;
		$this->PDO = $PDO;
		global $Core;
		$this->Core = $Core;
		global $Query;
		$this->Query = $Query;
		global $User;
		$this->User = $User;
		global $Caser;
		$this->Caser = $Caser;
		$this->plugDir = $this->Core->url() . "Note";
	}

	public function places(){
		return array(
			"events" => "Събития",
			"spravki" => "Справки",
			"payment" => "Плащания",
			"incoming" => "Входящи",
			"outgoing" => "Изходящи"
		);
	}

	public function edit($id){
	?>
		<button type="button" class="button" onclick="window.open('<?php echo $this->plugDir . "/edit?id=" . $id;?>', '_blank')">E</button>
	<?php
	}

	public function hide($id,$type,$elem){
	?>
		<button type="button" class="button" onclick="if(confirm('Сигурни ли сте')){ S.post('<?php echo $this->plugDir . "/query/hide?id=" . $id . "&type=" . $type;?>', '', '<?php echo $elem;?>');} <?php if($type=='short'){?>S.hide('<?php echo $elem;?>')<?php }?>">X</button>
	<?php
	}

	public function _($where, $case_id, $place, $element){
	?>
		<table class="center">
		<?php
		$cnt = 1;
		foreach($this->PDO->query("SELECT * FROM note" . $where) as $note){
			$case = $this->Query->select($note["case_id"], "id", "caser");
		?>
			<tr id="noteRow<?php echo $note["id"];?>" class="incomingsDocs">
				<td><?php echo $cnt;?></td>
				<td><?php echo $note["note"];?></td>
				<td><?php echo $this->edit($note["id"]);?></td>
				<td><?php echo $this->hide($note["id"], "short", "#noteRow" . $note["id"]);?></td>
			</tr>
		<?php
		$cnt++;
		}
		?>
		<tr><td colspan="100%"><button type="button" class="button" onclick="S.show('#addNote<?php echo $case_id;?>')">+</button></td></tr>
		<tr id="addNote<?php echo $case_id;?>" class="hide">
			<td colspan="100%">
				<textarea id="noteText<?php echo $case_id;?>" onchange="csi.trim(this)"></textarea>
				<br/>
				<button type="button" onclick="S.hide('#addNote<?php echo $case_id;?>')">-</button>
				<button type="button"
				onclick="S.post('<?php echo $this->plugDir . "/query/add";?>',
				{note: $('#noteText<?php echo $case_id;?>').val(),
				case_id: <?php echo $case_id;?>,
				doc_id: 0,
				<?php echo $place;?>: 1,
				where: '<?php echo $where;?>',
				place: '<?php echo $place;?>',
				element: '<?php echo $element;?>'
				},
				'<?php echo $element;?>'

				)">Save</button>
			</td>
		</tr>
		</table>
	<?php
		$check_creditor_over = $this->PDO->query("SELECT number, date FROM document WHERE name='51' AND case_id='" . $case_id . "'");
		if($check_creditor_over->rowCount() > 0){
			global $date;
			$cred_over = $check_creditor_over->fetch();
			?>
				<h3 class="incomingsDocs">Молба за приключване на делото от взискател: <?php echo $cred_over["number"];?>/<?php echo dates::_($cred_over["date"]);?> г.</h3>
			<?php
		}
	}


	public function listing($where="", $case_id=false, $person_id=false){
		global $csi;
	?>
		<table class="listTable" border="1px">
			<th>№</th>
			<th>Бележка</th>
			<th>Дело</th>
			<th>Длъжник</th>
			<th>Потребител</th>
			<th>Документ</th>
			<th>Дата</th>
			<th>Период</th>
			<th>Скрито</th>
			<th>Раздели</th>
			<th colspan="2"><button type="button" class="button" onclick="window.open('<?php echo $this->plugDir . '/add'; if($case_id){ echo '?case_id=' . $case_id;} elseif($person_id){ echo '?person_id=' . $person_id;}?>', '_self')">ADD</button></th>

		<?php
		$cnt = 1;
		if(isset($_GET["notePlace"])){
			if($where == ""){
				$where = "WHERE " . $_GET["notePlace"] . "=1";
			} else {
				$splitWhere = explode("ORDER", $where);
				$where = $splitWhere[0] . " AND " . $_GET["notePlace"] . "=1 ORDER" . $splitWhere[1];
			}
		}

		foreach($this->PDO->query("SELECT * FROM note" . $where . $notePlace) as $note){
			global $date;
			$Caser = new \plugin\Caser\php\Caser($note["case_id"]);
			$noteColor = (strtotime($note["period"]) < strtotime(date("Y-m-d H:i:s")) && $note["period"] != '0000-00-00 00:00:00') ? 'class="incomingsDocs"' : '';
		?>
			<tr <?php echo $noteColor;?>>
				<td><?php echo $cnt;?></td>
				<td><?php echo $note["note"];?></td>
				<td><?php echo $Caser->open();?></td>
				<td>
					<?php
						if($note["debtor_id"] != "0"){
							$debtor =  $this->Query->select($note["debtor_id"], "id", "person");
					?>
						<div><?php echo $debtor["name"];?></div>
						<div><?php echo $debtor["EGN_EIK"];?></div>
					<?php
						}
					?>
				</td>
				<td><?php if($note["user_id"] != "0"){echo $this->Query->select($note["user_id"], "id", $this->User->table, "email")["email"];}?></td>
				<td>
					<?php
						if($note["doc_id"] != "0"){
							$document =  $this->Query->select($note["doc_id"], "id", "document");
					?>
						<div><?php echo $this->Query->select($document["name"], "id", "doc_types", "name")["name"];?></div>
						<div><?php echo $document["number"];?>/<?php echo date("d.m.Y", strtotime($document["date"]));?></div>
					<?php
						}
					?>
				</td>
				<td><?php echo dates::_($note["date"]);?></td>
				<td><?php if(dates::set($note["period"])){echo dates::_($note["period"]);}?></td>
				<td id="hide<?php echo $note["id"];?>"><?php if($note["hide"] != "0000-00-00 00:00:00"){echo $note["hide"];}?></td>
				<td>
					<?php foreach($this->places() as $key=>$value){
						if($note[$key]){ ?> <div><?php echo $value;?></div> <?php }
					}?>
				</td>
				<td><?php echo $this->edit($note["id"]);?></td>
				<td><?php echo $this->hide($note["id"], "full", "#hide" . $note["id"]);?></td>
			</tr>
		<?php
		$cnt++;
		}
		?>
		</table>
	<?php
	}
}

$Note = new Note;
?>

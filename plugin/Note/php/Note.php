<?php
namespace plugin\Note;
include_once(\system\Core::doc_root() . "/web/php/Dates.php");

class Note{
	public static function places(){
		return array(
			"events" => "Събития",
			"spravki" => "Справки",
			"payment" => "Плащания",
			"incoming" => "Входящи",
			"outgoing" => "Изходящи"
		);
	}

	public static function edit($id){
	?>
		<button type="button" class="button" onclick="window.open('<?php echo \system\Core::url() . "Note/edit?id=" . $id;?>', '_blank')">E</button>
	<?php
	}

	public static function hide($id,$type,$elem){
	?>
		<button type="button" class="button" onclick="if(confirm('Сигурни ли сте')){ S.post('<?php echo \system\Core::url() . "Note/query/hide?id=" . $id . "&type=" . $type;?>', '', '<?php echo $elem;?>');} <?php if($type=='short'){?>S.hide('<?php echo $elem;?>')<?php }?>">X</button>
	<?php
	}

	public static function _($where, $case_id, $place, $element){
	?>
		<table class="center">
		<?php
		$cnt = 1;
		foreach($GLOBALS["PDO"]->query("SELECT * FROM note" . $where) as $note){
			$case = $GLOBALS["PDO"]->query("SELECT * FROM caser WHERE id='" . $note["case_id"] . "'")->fetch();	
		?>
			<tr id="noteRow<?php echo $note["id"];?>" class="incomingsDocs">
				<td><?php echo $cnt;?></td>
				<td><?php echo $note["note"];?></td>
				<td><?php echo static::edit($note["id"]);?></td>
				<td><?php echo static::hide($note["id"], "short", "#noteRow" . $note["id"]);?></td>
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
				onclick="S.post('<?php echo \system\Core::url() . "Note/query/add";?>',
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
		$check_creditor_over = $GLOBALS["PDO"]->query("SELECT number, date FROM document WHERE name='51' AND case_id='" . $case_id . "'");
		if($check_creditor_over->rowCount() > 0){
			global $date;
			$cred_over = $check_creditor_over->fetch();
			?>
				<h3 class="incomingsDocs">Молба за приключване на делото от взискател: <?php echo $cred_over["number"];?>/<?php echo \web\dates::_($cred_over["date"]);?> г.</h3>
			<?php
		}
	}


	public static function listing($where="", $case_id=false, $person_id=false){
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
			<th colspan="2"><button type="button" class="button" onclick="window.open('<?php echo \system\Core::url() . 'Note/add'; if($case_id){ echo '?case_id=' . $case_id;} elseif($person_id){ echo '?person_id=' . $person_id;}?>', '_self')">ADD</button></th>

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

		foreach($GLOBALS["PDO"]->query("SELECT * FROM note" . $where) as $note){
			global $date;
			$Caser = new \plugin\Caser\Caser($note["case_id"]);
			$noteColor = (strtotime($note["period"]) < strtotime(date("Y-m-d H:i:s")) && $note["period"] != '0000-00-00 00:00:00') ? 'class="incomingsDocs"' : '';
		?>
			<tr <?php echo $noteColor;?>>
				<td><?php echo $cnt;?></td>
				<td><?php echo $note["note"];?></td>
				<td><?php echo $Caser->open();?></td>
				<td>
					<?php
						if($note["debtor_id"] != "0"){
							$debtor =  $GLOBALS["PDO"]->query("SELECT * FROM person WHERE id='" . $note["debtor_id"] . "'")->fetch();
					?>
						<div><?php echo $debtor["name"];?></div>
						<div><?php echo $debtor["EGN_EIK"];?></div>
					<?php
						}
					?>
				</td>
				<td><?php if($note["user_id"] != "0"){echo $GLOBALS["PDO"]->query("SELECT email FROM " . $GLOBALS["User"]->table . " WHERE id='" . $note["user_id"] . "'")->fetch()["email"];}?></td>
				<td>
					<?php
						if($note["doc_id"] != "0"){
							$GLOBALS["PDO"]->query("SELECT * FROM document WHERE id='" . $note["doc_id"] . "'")->fetch();
							$document =  $GLOBALS["PDO"]->query("SELECT * FROM document WHERE id='" . $note["doc_id"] . "'")->fetch();
					?>
						<div><?php echo $GLOBALS["PDO"]->query("SELECT name FROM doc_types WHERE id='" . $document["name"] . "'")->fetch()["name"];?></div>
						<div><?php echo $document["number"];?>/<?php echo date("d.m.Y", strtotime($document["date"]));?></div>
					<?php
						}
					?>
				</td>
				<td><?php echo \web\dates::_($note["date"]);?></td>
				<td><?php if(\web\dates::set($note["period"])){echo \web\dates::_($note["period"]);}?></td>
				<td id="hide<?php echo $note["id"];?>"><?php if($note["hide"] != "0000-00-00 00:00:00"){echo $note["hide"];}?></td>
				<td>
					<?php foreach(static::places() as $key=>$value){
						if($note[$key]){ ?> <div><?php echo $value;?></div> <?php }
					}?>
				</td>
				<td><?php echo static::edit($note["id"]);?></td>
				<td><?php echo static::hide($note["id"], "full", "#hide" . $note["id"]);?></td>
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

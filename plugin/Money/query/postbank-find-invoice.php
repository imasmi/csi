<?php
	$cnt = 0;
	foreach($PDO->query("SELECT * FROM invoice WHERE case_id='" . $_POST["case_id"] . "' ORDER by date DESC, type DESC") as $invoice){
		++$cnt;
		$type = ($invoice["type"] == "invoice") ? "Фактура" : "Сметка";
		$number = ($invoice["type"] == "invoice") ? $invoice["invoice"] : $invoice["bill"];
		?>
			<input type="checkbox" name="invoicing_<?php echo $_POST["cnt"];?>_<?php echo $cnt;?>" value="<?php echo $invoice["id"];?>"><?php echo $type . " " . $number . "/" . $date->_($invoice["date"]) . " за " . $invoice["sum"];?> лева
			<br/>
		<?php
	}
?>
<input type="hidden" name="invoicing_<?php echo $_POST["cnt"];?>_cnt" value="<?php echo $cnt;?>"/>

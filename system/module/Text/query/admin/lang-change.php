<?php
$textField = $Query->select($_POST["id"], "id", $Text->table, $_POST["lang"]);

echo $textField[$_POST["lang"]];
?>

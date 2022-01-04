<?php
echo $PDO->query("SELECT " . $_POST["lang"] . " FROM " . $Text->table . " WHERE id='" . $_POST["id"] . "'")->fetch()[$_POST["lang"]];
?>

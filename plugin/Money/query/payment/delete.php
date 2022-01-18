<?php
$PDO->query("DELETE FROM payment WHERE id='" . $_GET["id"] . "'");
//\system\Database::cleanup($value,  $selector="id", $table="module", $delimeter="=")
//Use #\system\Database::cleanup function to delete data from default Imasmi web tables (page | text | file | setting)
?>
<script>history.go(-2)</script>
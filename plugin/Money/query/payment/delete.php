<?php
$PDO->query("DELETE FROM payment WHERE id='" . $_GET["id"] . "'");
//\system\Data::cleanup($value,  $selector="id", $table="module", $delimeter="=")
//Use #\system\Data::cleanup function to delete data from default Imasmi web tables (page | text | file | setting)
?>
<script>history.go(-2)</script>
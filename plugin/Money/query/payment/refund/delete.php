<?php
$Query->remove($_GET["id"], "id", $Setting->table);
#$Query->remove($value,  $selector="id", $table="module", $delimeter="=")
#$Query->cleanup($value,  $selector="id", $table="module", $delimeter="=")
//Use #$Query->cleanup function to delete data from default Imasmi web tables (page | text | file | setting)
?>
<script>history.go(-2)</script>
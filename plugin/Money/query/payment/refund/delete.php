<?php
\system\Database::remove($_GET["id"], "id", $Setting->table);
#\system\Database::remove($value,  $selector="id", $table="module", $delimeter="=")
#\system\Database::cleanup($value,  $selector="id", $table="module", $delimeter="=")
//Use #\system\Database::cleanup function to delete data from default Imasmi web tables (page | text | file | setting)
?>
<script>history.go(-2)</script>
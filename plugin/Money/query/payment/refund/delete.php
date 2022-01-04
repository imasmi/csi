<?php
\system\Query::remove($_GET["id"], "id", $Setting->table);
#\system\Query::remove($value,  $selector="id", $table="module", $delimeter="=")
#\system\Query::cleanup($value,  $selector="id", $table="module", $delimeter="=")
//Use #\system\Query::cleanup function to delete data from default Imasmi web tables (page | text | file | setting)
?>
<script>history.go(-2)</script>
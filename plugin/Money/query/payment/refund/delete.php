<?php
\system\Data::remove($_GET["id"], "id", $Setting->table);
#\system\Data::remove($value,  $selector="id", $table="module", $delimeter="=")
#\system\Data::cleanup($value,  $selector="id", $table="module", $delimeter="=")
//Use #\system\Data::cleanup function to delete data from default Imasmi web tables (page | text | file | setting)
?>
<script>history.go(-2)</script>
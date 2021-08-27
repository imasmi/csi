<?php
#MAKE USER DELETED
$PDO->query("UPDATE " . $Query->table() . " SET deleted=NOW() WHERE id='" . $_GET["id"] . "'");

#GO TO HOMEPAGE
?><script>history.go(-1)</script><?php
?>
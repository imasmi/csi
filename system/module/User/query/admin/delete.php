<?php
#MAKE USER DELETED
$PDO->query("UPDATE " . \system\Data::table() . " SET deleted=NOW() WHERE id='" . $_GET["id"] . "'");

#GO TO HOMEPAGE
?><script>history.go(-1)</script><?php
?>
<?php
#SEND HOME IF USER OF ANY TYPE IS NOT LOGGED
$User->control();

#MAKE USER DELETED
$PDO->query("UPDATE " . $Query->table() . " SET deleted=NOW() WHERE id='" . $User->_("id") . "'");

#UNSET CURRENT SESSION USER
unset($_SESSION["user"]);
unset($_SESSION["role"]);

#GO TO HOMEPAGE
?>
<script>location.href = '<?php echo $Core->url();?>';</script>
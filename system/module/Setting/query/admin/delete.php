<?php
\system\Database::cleanup($_GET["id"]);
#GO TO HOMEPAGE
?><script>history.go(-2)</script><?php
?>
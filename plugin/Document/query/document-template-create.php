<?php 
$Template = $Plugin->object("Template", $_GET["id"]);
$Template->create($_GET["path"]);
?>
<script>history.back()</script>
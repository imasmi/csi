
<?php 
include_once(\system\Core::doc_root() . "/plugin/Note/php/Note.php");
?>
<div class="admin">
<h2 class="text-center">ИЗВЕСТИЯ</h2>
<?php \plugin\Note\Note::listing(" WHERE events=1 AND hide is NULL AND period <= NOW() ORDER by period ASC");?>
</div>
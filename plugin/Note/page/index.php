<div class="admin">
<h2 class="text-center">ИЗВЕСТИЯ</h2>
<?php $Note->listing(" WHERE events=1 AND hide is NULL AND period <= NOW() ORDER by period ASC");?>
</div>
<?php
//security check
if($User->role === false && $Module->_() != "User"){
?>
<script>location.href='<?php echo $Core->url();?>user';</script>
<?php
exit;
}

if($_SERVER["REQUEST_URI"] == "/csi/"){
?>
  <script>location.href='<?php echo $Core->url();?>Note/index';</script>
<?php
}
?>

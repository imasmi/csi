<script src="<?php echo \system\Core::url();?>system/js/System.js"></script>
<?php
if($User->group("admin")){
?>
  <script src="<?php echo \system\Core::url();?>system/module/File/js/FileAPP.js"></script>
  <script src="<?php echo \system\Core::url();?>system/module/Text/js/TextAPP.js"></script>
  <script src="<?php echo \system\Core::url();?>system/module/Text/js/jscolor.min.js"></script>
  <script src="<?php echo \system\Core::url();?>system/module/Listing/js/ListingAPP.js"></script>
<?php
}
?>

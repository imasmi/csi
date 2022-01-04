<?php
if($User->group("admin")){
    echo $TextAPP->wysiwyg();
    echo '<input type="hidden" id="lang" value="' . $Language->_() . '"/>';
}
?>

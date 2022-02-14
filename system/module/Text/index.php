<?php
if($User->group("admin")){
    echo \module\Text\TextAPP::wysiwyg();
    echo '<input type="hidden" id="lang" value="' . $Language->_() . '"/>';
}
?>

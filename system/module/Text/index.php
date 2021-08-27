<?php
if($User->_() === "admin"){
    $TextAPP = new \system\module\Text\php\TextAPP();
    echo $TextAPP->wysiwyg();
    echo '<input type="hidden" id="lang" value="' . $Language->_() . '"/>';
}
?>
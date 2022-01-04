<?php
if (strpos($_GET["url"], 'query') === false) {
    $link = \system\Core::links();
    #check for user role permission in current location path
    foreach($User->column_group as $role){
        if(in_array(strtolower($role),  $link)){ $User->control("admin");}
    }
    
    #find page by current url
    $open_current = $Page->current_file;
    if($open_current !== false){
        require_once($open_current);
    } elseif($Page->id == 0) {
        echo 'Error page';
    }
}
?>
<div id="loading">
    <div class="background"></div>
    <img src="<?php echo \system\Core::url();?>system/file/loading.gif" alt="Imasmi web loading"/>
</div>
<input type="hidden" id="URL" value="<?php echo \system\Core::url();?>"/>
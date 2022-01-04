<?php 
$info = parse_ini_file(\system\Core::doc_root() . "/system/module/Theme/blank/theme.info", true, INI_SCANNER_RAW);
?>
<div class="frame">
    <h3>Create your own blank theme</h3>
    <div class="clear">
        <div class="file-edit column-6"><img class="image" src="<?php echo \system\Core::url();?>system/module/Theme/blank/file/1.png"/></div>
        <div class="column-6">
            <?php echo $info["description"];?>
        </div>
    </div>
    
    <form method="post" action="<?php echo \system\Core::query_path(0, -1);?>/blank" onsubmit="return S.post('<?php echo \system\Core::query_path(0, -1);?>/blank', S.serialize(this), '#error-message')">
        <div class="clear">
            <div class="column-6">Name</div>
            <div class="column-6"><input type="text" id="name" name="name" required/></div>
        </div>
        
        <div id="error-message"></div>
        <button class="button">Submit</button>
    </form>
</div>
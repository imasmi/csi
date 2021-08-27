<div class="admin">
<div class="title">Add backup</div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path();?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path();?>', S.serialize('#form'), '#error-message');">
    <table class="table">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="name" required min="3"/></td>
        </tr>
        
        <tr>
            <td>Type</td>
            <td>
                <?php $types = array("full", "plugin", "web");?>
                <select name="type" id="type" required onchange="if(this.value == 'plugin'){S('#plugin').style.display = 'table-row';} else {S.hide('#plugin');}; if(S('#database').checked === true && (this.value == 'web' || this.value == 'plugin')){S.post('<?php echo $Core->query_path(0, -1);?>/tables_select', {'type' : S('#type').value, 'plugin' : S('input[name=\'plugin\']:checked').value}, '#tables');} else {S('#tables').innerHTML = '';}">
                    <option value="">SELECT</option>
                    <?php foreach($types as $type){?>
                        <option value="<?php echo $type;?>"<?php if($_GET["type"] == $type){ echo " selected";}?>><?php echo ucfirst($type);?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        
        <tr id="plugin" <?php if($_GET["type"] != "plugin"){?>class="hide"<?php } ?>>
            <td>Plugin</td>
            <td>
                <?php 
                $cnt = 0;
                foreach($plugin as $plugin => $value){
                ++$cnt;
                ?>
                <div>
                    <input type="radio" name="plugin" id="plugin" value="<?php echo $plugin;?>" <?php if($cnt == 1){echo 'checked';}?> onchange="if(S('#database').checked === true){S.post('<?php echo $Core->query_path(0, -1);?>/tables_select', {'type' : S('#type').value, 'plugin' : this.value}, '#tables');} else {S('#tables').innerHTML = '';}"/>
                    <span><?php echo $plugin;?></span>
                </div>
                <?php } ?>
            </td>
        </tr>
        
        <tr>
            <td>Files</td>
            <td><input type="checkbox" name="files" id="files" checked/></td>
        </tr>
        
        <tr>
            <td>Database</td>
            <td>
                <input type="checkbox" name="database" id="database" onchange="if(this.checked === true){S.post('<?php echo $Core->query_path(0, -1);?>/tables_select', {'type' : S('#type').value, 'plugin' : S('input[name=\'plugin\']:checked').value}, '#tables');} else {S('#tables').innerHTML = '';}"/>
                <div id="tables"></div>
            </td>
        </tr>
        
        <tr>
            <td>Description</td>
            <td><textarea name="description"></textarea></td>
        </tr>
        
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
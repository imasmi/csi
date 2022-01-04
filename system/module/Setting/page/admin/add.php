<div class="admin">
<div class="title">Add setting</div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Field</td>
            <td><input type="text" name="field" id="field" required/></td>
        </tr>
        
        <tr>
            <td>Page id</td>
            <td><input type="text" name="page_id" id="page_id"/></td>
        </tr>
        
        <tr>
            <td>Link id</td>
            <td><input type="text" name="link_id" id="link_id"/></td>
        </tr>
        
        <tr>
            <td>Value</td>
            <td><input type="text" name="value" id="value"/></td>
        </tr>
        
        <?php foreach($Language->items as $key=>$value){?>
        <tr>
            <td><?php echo $key;?></td>
            <td><input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>"/></td>
        </tr>
        <?php }?>
        
        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
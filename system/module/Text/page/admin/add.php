<?php 
include_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;?>
<div class="admin">
<div class="error-message" id="error-message"></div>
<div class="title text-center">Add text</div>
<form class="form" id="add-text" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#add-text'), '#error-message')">
    <table class="table">
        <tr>
            <th>Page</th>
            <td><?php $PageAPP->select("page_id");?></td>
        </tr>
        
        <tr>
            <td>Label</td>
            <td><input type="text" name="tag" id="tag" required/></td>
        </tr>
        
        <?php foreach($Language->items as $key => $value){?>
        <tr>
            <td><?php echo $key;?></td>
            <td><textarea name="<?php echo $value;?>" id="<?php echo $value;?>"></textarea></td>
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
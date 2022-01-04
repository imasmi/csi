<?php $Object = $Plugin->object();?>
<div class="admin">
<h2 class="text-center">Add <?php echo $Object->plugin;?> item</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path();?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Type</td>
            <td><?php echo $Form->select("type", \system\Query::column_group("type", $Object->table), array("addon" => true));?></td>
        </tr>
        
        <tr>
            <td>Menu</td>
            <td><?php echo $Form->select("menu", \system\Query::column_group("menu", $Object->table), array("addon" => true));?></td>
        </tr>
        
        <?php foreach($Language->items as $key=>$value){?>
        <tr>
            <td><?php echo $key;?> link</td>
            <td>
                <?php echo $Info->_("Add http prefix and full path if you want to add custom link");?>
                <input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>"/>
            </td>
        </tr>
        <?php }?>

        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Next");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
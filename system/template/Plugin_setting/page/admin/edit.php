<?php 
$Object = $Plugin->object();
$select = $PDO->query("SELECT * FROM " . $Setting->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
?>
<div class="admin">
<div class="title">Edit <?php echo $Object->plugin;?> item</div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];;?>" method="post" onsubmit="return S.post('<?php echo \system\Core::query_path() .  '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <?php foreach($Language->items as $key=>$value){?>
        <tr>
            <td><?php echo $key;?> name</td>
            <td>
                <input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" value="<?php echo $select[$value];?>"/>
            </td>
        </tr>
        <?php }?>
        <tr>
            <td colspan="2" class="text-center">
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
                <button class="button"><?php echo $Text->item("Next");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
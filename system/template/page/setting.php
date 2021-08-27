<?php $select = $Query->select($_GET["id"], "id", $Page->table);?>

<div class="admin">
<div class="title">Edit <?php echo $select["id"];?></div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>template</td>
            <td><input type="text" name="template" id="template" value="<?php echo $select["template"];?>"/></td>
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
<?php
$select = $Query->select($_GET["id"]);
#$Query->select($value, $selector="id", $table="module", $fields="*", $delimeter="=")
?>

<div class="admin">
<h2 class="title"><?php echo $select["field"];?></h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Field</td>
            <td><input type="text" name="field" id="field" value="<?php echo $select["field"];?>"/></td>
        </tr>
        
        <tr>
            <td>Page id</td>
            <td><input type="text" name="page_id" id="page_id" value="<?php echo $select["page_id"];?>"/></td>
        </tr>
        
        <tr>
            <td>Link id</td>
            <td><input type="text" name="link_id" id="link_id" value="<?php echo $select["link_id"];?>"/></td>
        </tr>
        
        <tr>
            <td>Value</td>
            <td><input type="text" name="value" id="value" value="<?php echo $select["value"];?>"/></td>
        </tr>
        
        <?php foreach($Language->items as $key=>$value){?>
        <tr>
            <td><?php echo $key;?></td>
            <td><input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" value="<?php echo $select[$value];?>"/></td>
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
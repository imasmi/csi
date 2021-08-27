<?php
$select = $Query->select($_GET["id"]);
$PageAPP = new \system\module\Page\php\PageAPP;
?>

<div class="admin">
<div class="title"><?php echo ltrim($Page->url($_GET["id"]), "/");?></div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return S.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', S.serialize('#form'), '#error-message')">
    <table class="table">
        <tr>
            <td>Tag</td>
            <td><?php echo $Form->select("tag",array("theme" => "Theme") + $Query->column_group("type"), array("select" => $select["tag"], "required" => true, "addon" => true));?></td>
        </tr>
        
        <tr>
            <td>Filename</td>
            <td>
                Left blank will remove file if exists<br/>
                <input type="text" name="filename" id="filename" value="<?php echo $select["filename"];?>"/>
            </td>
        </tr>
        
        <tr>
            <td>Menu</td>
            <td><?php echo $Form->select("menu", $Query->column_group("menu"), array("select" => $select["menu"], "addon" => true));?></td>
        </tr>
        
        <?php foreach($Language->items as $key=>$value){?>
        <tr>
            <td><?php echo $key;?> link</td>
            <td>
                Add http prefix and full path if you want to add custom link<br/>
                <input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" required value="<?php echo $select[$value];?>"/>
            </td>
        </tr>
        <?php }?>
        
        <tr>
            <td>Homepage</td>
            <td><input type="checkbox" name="homepage" id="homepage" <?php if($select["type"] == "homepage"){ echo "checked";};?>/></td>
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
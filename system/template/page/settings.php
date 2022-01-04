<?php
$File = new \module\File\File($_GET["id"]);
$SettingAPP = new \module\Setting\SettingAPP($_GET["id"]);
$FileAPP = new system\module\File\FileAPP($_GET["id"]);

$select = $select = $PDO->query("SELECT * FROM " . $Page->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
$abbrevs = $Language->items;
?>

<div class="admin">
<div class="title"><?php echo $select[$Language->_()];?> settings</div>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" enctype="multipart/form-data">
<!--<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return Core.post('<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>', Core.serialize('#form'), '#error-message')">-->
    <input type="hidden" name="page_id" value="<?php echo $_GET["id"];?>"/>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Value</th>
            <?php foreach($abbrevs as $key=>$value){?>
            <th><?php echo $key;?></th>
            <?php } ?>
        </tr>
        
        <?php $SettingAPP->set("Title", array("columns" => "languages", "page_id" => $_GET["id"], "type" => "text"));?>
        <?php $SettingAPP->set("Menu", array("columns" => "languages", "page_id" => $_GET["id"], "type" => "text"));?>
        <?php $SettingAPP->set("Description", array("columns" => "languages", "page_id" => $_GET["id"], "type" => "textarea"));?>
        <?php $SettingAPP->set("Keywords", array("columns" => "languages", "page_id" => $_GET["id"], "type" => "text"));?>
        
        <tr>
            <td>Og image</td>
            <td>
                <?php if(isset($File->items["Og"]) && $File->items["Og"]["page_id"] == $_GET["id"]){
                    $FileAPP->input_edit($File->items["Og"]);
                } else {
                    $FileAPP->input("Og", array("accept"=> "png,jpg,jpeg,gif", "tag" => "Og"));
                }?>
            </td>
        </tr>
        
        <tr>
            <td colspan="5" class="text-center">
                <button class="button"><?php echo $Text->item("Save");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
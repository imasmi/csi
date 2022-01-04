<?php
require_once(\system\Core::doc_root() . "/system/module/Setting/php/SettingAPP.php");
$SettingAPP_page = new \module\Setting\SettingAPP($_GET["id"]);
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP_page = new \module\File\FileAPP($_GET["id"]);
$select = $PDO->query("SELECT * FROM " . $Page->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
$abbrevs = $Language->items;
?>

<div class="admin">
<h2 class="text-center"><?php echo $SettingAPP_page->_("Title") ? $SettingAPP_page->_("Title") : $select[$Language->_()];?></h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"]; if(isset($_GET["goBack"])){ echo '&goBack=' . $_GET["goBack"];} if(isset($_GET["goTo"])){ echo '&goTo=' . str_replace("&", "%26",$_GET["goTo"]);}?>" method="post" enctype="multipart/form-data">
<!--<form class="form" id="form" action="<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return Core.post('<?php echo \system\Core::query_path() . '?id=' . $_GET["id"];?>', Core.serialize('#form'), '#error-message')">-->
    <input type="hidden" name="page_id" value="<?php echo $_GET["id"];?>"/>
    <table class="table">
        <tr>
            <th></th>
            <?php foreach($abbrevs as $key=>$value){?>
            <th><?php echo $key;?></th>
            <?php } ?>
        </tr>

        <?php $SettingAPP_page->set("Title", array("column" => "language", "page_id" => $_GET["id"], "type" => "text"));?>
        <?php $SettingAPP_page->set("Menu", array("column" => "language", "page_id" => $_GET["id"], "type" => "text"));?>
        <?php $SettingAPP_page->set("Description", array("column" => "language", "page_id" => $_GET["id"], "type" => "textarea"));?>
        <?php $SettingAPP_page->set("Keywords", array("column" => "language", "page_id" => $_GET["id"], "type" => "text"));?>

        <tr>
            <td>Og image</td>
            <td>
                <?php if(isset($FileAPP_page->items["Og"])){
                    $FileAPP_page->input_edit($FileAPP_page->items["Og"]);
                } else {
                    $FileAPP_page->input("Og", array("accept"=> "png,jpg,jpeg,gif", "tag" => "Og"));
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

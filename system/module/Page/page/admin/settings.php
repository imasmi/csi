<?php
// THIS VARIANT IS DEPRECATED AND WILL BE REMOVED IN FUTURE EDITIONS

$SettingAPP_page = new \system\module\Setting\php\SettingAPP($_GET["id"]);
$FileAPP_page = new system\module\File\php\FileAPP($_GET["id"]);
$select = $Query->select($_GET["id"], "id", $Page->table);
$abbrevs = $Language->items;


#$select = $Query->select($_GET["id"]);
#$Query->select($value, $selector="id", $table="module", $fields="*", $delimeter="=")
?>

<div class="admin">
<h2 class="text-center"><?php echo $SettingAPP_page->_("Title") ? $SettingAPP_page->_("Title") : $select[$Language->_()];?></h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"]; if(isset($_GET["goBack"])){ echo '&goBack=' . $_GET["goBack"];} if(isset($_GET["goTo"])){ echo '&goTo=' . str_replace("&", "%26",$_GET["goTo"]);}?>" method="post" enctype="multipart/form-data">
<!--<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>" method="post" onsubmit="return Core.post('<?php echo $Core->query_path() . '?id=' . $_GET["id"];?>', Core.serialize('#form'), '#error-message')">-->
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
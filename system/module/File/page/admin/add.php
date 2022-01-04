<?php
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP;
$array = array("tag" => true, "multiple" => true, "languages" => true);
if(isset($_GET["gallery"])){$array["link_id"] = $_GET["gallery"];}
?>
<div class="admin">
    <form enctype="multipart/form-data" action="<?php echo \system\Core::url();?>File/query/admin/add" method="post" class="form">
        <table class="table" id="add-file" border="0px" cellspacing="0px">
            <tr><td><?php echo $FileAPP->input("image", $array);?></td></tr>
            <tr>
                <td class="text-center">
                    <button class="button"><?php echo $Text->item("Save");?></button>
                    <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
                </td>
            </tr>
        </table>
    </form>
</div>

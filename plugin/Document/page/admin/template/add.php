<?php 
$Object = $Plugin->object("Template");
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP_page = new \module\File\FileAPP;
?>
<div class="admin">
<h2 class="text-center title">Добавяне на шаблон</h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo \system\Core::query_path();?>" method="post" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <td>Файл</td>
            <td><?php $FileAPP_page->input("template", array("accept"=> "application/vnd.oasis.opendocument.text"));?></td>
        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
                <button class="button"><?php echo $Text->item("Next");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
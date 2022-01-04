<?php
$file = $PDO->query("SELECT * FROM " . $File->table . " WHERE id='" . $_POST["id"] . "'")->fetch();
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($file["page_id"]);
?>
<div class="white-bg popup-content">
    <form enctype="multipart/form-data" action="<?php echo \system\Core::url();?>File/query/admin/replace-file" method="post" class="admin">
        <h3>UPDATE FILE:</h3>
        <div class="title"><?php echo (isset($file["tag"]) ? $file['tag'] : $file['id']);?></div>
        <input type="hidden" name="method" value="post"/>
        <?php $FileAPP->input_edit($file, array("languages" => true));?>
        <br/><br/>
        <div>
            <button class="button"><?php echo $Text->item("Save");?></button>
            <button class="button" type="button" onclick="S.popupExit()">Close</button>
        </div>
    </form>
</div>

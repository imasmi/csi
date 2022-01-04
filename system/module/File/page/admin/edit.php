<?php
require_once(\system\Core::doc_root() . "/system/php/Form.php");
$Form = new \system\Form;

$file = $PDO->query("SELECT * FROM " . $File->table . " WHERE id='" . $_GET["id"] . "'")->fetch();
require_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP($file["page_id"]);
?>
<form enctype="multipart/form-data" action="<?php echo \system\Core::url();?>File/query/admin/replace-file?id=<?php echo $_GET["id"];?>" method="post" class="admin">
    <h3>UPDATE FILE:</h3>
    <div class="title"><?php echo ($file["tag"] !== "" ? $file['tag'] : $file['id']);?></div>
    <input type="hidden" name="method" value="get"/>
    <?php $FileAPP->input_edit($file, array("full" => true));?>
    <?php if($file["link_id"] != 0){ ?>
    <div>Category</div>
    <?php
        $cats = array();
        foreach($PDO->query("SELECT id, " . $Language->_() . " FROM " . $File->table . " WHERE link_id='" . \system\Query::top_id($file["link_id"], "link_id", "id") . "' AND type='gallery'") as $category){
            $cats[$category["id"]] = $category[$Language->_()];
        }
        \system\Form::select("link_id_" . $_GET["id"], $cats, array("select" => $file["page_id"]));
    ?>
    <?php } ?>
    <br/><br/>
    <div>
        <button class="button"><?php echo $Text->item("Save");?></button>
        <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
    </div>
</form>

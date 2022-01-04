<?php
require_once(\system\Core::doc_root() . "/system/module/Page/php/PageAPP.php");
$PageAPP = new \module\Page\PageAPP;
?>
<div class="title">Add gallery</div>
<div class="admin">
<div id="error-message"></div>
    <form class="form" id="add_gallery" method="post" action="<?php echo \system\Core::query_path();?>" >
        <input type="hidden" name="type" value="gallery"/>
        <input type="hidden" name="link_id" value="<?php echo $_GET["gallery"];?>"/>
        <table class="table">
            <tr>
                <td>Label</td>
                <td><input type="text" name="tag" id="tag" required/></td>
            </tr>

            <?php foreach($Language->items as $key=>$value){?>
            <tr>
                <td><?php echo $key;?> name</td>
                <td><input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" required/></td>
            </tr>
            <?php } ?>

            <?php if(!isset($_GET["gallery"])){?>
            <tr>
                <td>Page</td>
                <td><?php $PageAPP->select("page_id");?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="2" class="text-center">
                    <button class="button"><?php echo $Text->item("Save");?></button>
                    <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
                </td>
            </tr>
        </table>
    </form>
</div>

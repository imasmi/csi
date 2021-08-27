<div class="title">Add category to <?php echo $Query->select($_GET["gallery"])[$Language->_()];?></div>
<div class="admin">
<div id="error-message"></div>
    <form class="form" id="add_gallery" method="post" action="<?php echo $Core->query_path();?>" >
        <input type="hidden" name="type" value="gallery"/>
        <input type="hidden" name="link_id" value="<?php echo $_GET["gallery"];?>"/>
        <table class="table">
            
            <?php foreach($Language->items as $key=>$value){?>
            <tr>
                <td><?php echo $key;?> name</td>
                <td><input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" required/></td>
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
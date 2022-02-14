<?php
include_once(\system\Core::doc_root() . "/system/module/File/php/FileAPP.php");
$FileAPP = new \module\File\FileAPP(array("fortable" => "plugin"));
?>
<div class="admin">
    <form method="post" enctype="multipart/form-data" action="<?php echo \system\Core::query_path();?>">
        <h2>Create theme package</h2>
        <div class="clear marginY-10">
            <div class="column-6">Name</div>
            <div class="column-6"><input type="text" name="name" value="<?php echo $Theme->name;?>"/></div>
        </div>
        
        <div class="clear marginY-10">
            <div class="column-6">Version</div>
            <div class="column-6"><input type="number" name="version" value="<?php echo $Theme->data["version"];?>"/></div>
        </div>
        
        <div class="clear marginY-10">
            <div class="column-6">Website</div>
            <div class="column-6"><input type="text" name="website" value=""/></div>
        </div>
        
        <div class="clear marginY-10">
            <div class="column-6">Description</div>
            <div class="column-6"><textarea name="description"></textarea></div>
        </div>
        
        <div class="clear marginY-10">
            <div class="column-6">Preview</div>
            <div class="column-6"><?php echo $FileAPP->input("preview", array("accept" => "image/png, image/jpeg, image/gif"));?></div>
        </div>
        
        <div class="clear marginY-10">
            <div class="column-6">Plugins</div>
            <div class="column-6">
                <?php 
                foreach ($Plugin->items as $plugin => $data) {
                    if ($data["theme"] == $Theme->name) {
                        echo $plugin . '<br>';
                    }
                }
                ?>
                <a href="<?php echo \system\Core::url();?>Plugin/admin/index" class="button marginY-10">Edit</a>
            </div>
        </div>
        
        <button class="button">Submit</button>
    </form>
</div>
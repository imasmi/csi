<?php 
$select = $Query->select($_GET["id"]);
$PageAPP = new \system\module\Page\php\PageAPP($_GET["id"]);
$SettingAPP_select = new system\module\Setting\php\SettingAPP($_GET["id"]);
$FileAPP_page = new system\module\File\php\FileAPP($_GET["id"]);
?>
<div class="admin">
<h2 class="text-center title">Edit <?php echo $Page->map($_GET["id"]);?></h2>
<div class="error-message" id="error-message"></div>
<form class="form" id="form" action="<?php echo $Core->query_path();?>?id=<?php echo $_GET["id"];?>" method="post" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <td>Tag</td>
            <td><?php echo $Form->select("tag", array("theme" => "Theme") + $Query->column_group("tag"), array("select" => $select["tag"], "required" => true, "addon" => true));?></td>
        </tr>
        
        <tr>
            <td>Filename <?php echo $Info->_('<div>Left blank if you don not want to create a file</div>');?></td>
            <td><input type="text" name="filename" id="filename" value="<?php echo $select["filename"];?>"/></td>
        </tr>
        
        <tr>
            <td>Menu <?php echo $Info->_('<div>Select menu for the web page to appears in. If the page is attached to parent page, the parent page should also be included in the menu.</div>');?></td>
            <td><?php echo $Form->select("menu", $Query->column_group("menu"), array("select" => $select["menu"], "addon" => true));?></td>
        </tr>
        
        <tr>
            <td>Homepage</td>
            <td><input type="checkbox" name="homepage" id="homepage" <?php if($select["type"] == "homepage"){ echo "checked";};?>/></td>
        </tr>
    </table>
    
    <table class="table">
        <tr>
            <th></th>
            <?php foreach($Language->items as $key=>$value){?>
            <th><?php echo $key;?></th>
            <?php } ?>
        </tr>
        
        <tr>
            <td>URL <?php echo $Info->_('<div class="frame">URL (Uniform Resource Locator) is the internet address of your page. Allowed characters are - "A–Z a–z 0–9 . _ -". It is recommended to use lower case letters and separate words with hyphens, instead of underscores. All white spaces will be replaced automatically with hyphens by ImaSmi Web. Example: imasmi-web-framework-about. <div class="file-edit marginY-10"><img src="' . $Core->url() . 'system/file/page-setting/search-url.jpg"/></div></div>');?></td>
            <?php foreach($Language->items as $key=>$value){?>
            <td><input type="text" name="<?php echo $value;?>" id="<?php echo $value;?>" placeholder="<?php echo $key;?> URL" value="<?php echo $select[$value];?>"/></td>
            <?php }?>
        </tr>
        
        <tr>
            <td>Title <?php echo $Info->_('<div class="frame">Title is the name of a web page. It is displayed in the browsers tab and in results in the search engines (Google, Bing, Yahoo and etc.). Title tag has no characters limit, but it is considered best practise to stay under 70 characters. <div class="file-edit marginY-10"><img src="' . $Core->url() . 'system/file/page-setting/search-title.jpg"/></div>');?></td>
            <?php foreach($Language->items as $key=>$value){?>
            <td><input type="text" name="Title_<?php echo $value;?>" id="Title_<?php echo $value;?>" placeholder="<?php echo $key;?> title" value="<?php echo $SettingAPP_select->_("Title", array("column" => $value));?>"/></td>
            <?php }?>
        </tr>
        
        <tr>
            <td>Menu <?php echo $Info->_('<div class="frame">Menu name of the page on the website. It should point the user to which page of the website it will redirect. (Menu name is usually same as title or a shorthand version with the same meaning). <div class="file-edit marginY-10"><img src="' . $Core->url() . 'system/file/page-setting/menu-name.jpg"/></div>');?></td>
            <?php foreach($Language->items as $key=>$value){?>
            <td><input type="text" name="Menu_<?php echo $value;?>" id="Menu_<?php echo $value;?>" placeholder="<?php echo $key;?> menu" value="<?php echo $SettingAPP_select->_("Menu", array("column" => $value));?>"/></td>
            <?php }?>
        </tr>
        
        <tr>
            <td>Description <?php echo $Info->_('<div class="frame">Description is a short summary of the web page content. It is commonly displayed by search engines in search resutls under the Title tag. There is no general rule about the lenght of the description, but it is considered best practise to be between 120 and 160 characters. <div class="file-edit"><img src="' . $Core->url() . 'system/file/page-setting/search-description.jpg"/></div></div>');?></td>
            <?php foreach($Language->items as $key=>$value){?>
            <td><textarea name="Description_<?php echo $value;?>" id="Description_<?php echo $value;?>" placeholder="<?php echo $key;?> description"><?php echo $SettingAPP_select->_("Description", array("column" => $value));?></textarea></td>
            <?php }?>
        </tr>
        
        <tr>
            <td>Social media image <?php echo $Info->_('<div class="frame">An og:image (Open Graph) is an image to show when sharing content to social medias and chat platforms like Facebook, Viber and etc. The recommended size is 1200:630 pixels (or 1.91:1 aspect ratio), although some platforms may have different preferences.<div class="file-edit"><img src="' . $Core->url() . 'system/file/page-setting/og-image.jpg"/></div></div>');?></td>
            <td>
                <?php if(isset($FileAPP_page->items["Og"])){
                    $FileAPP_page->input_edit($FileAPP_page->items["Og"]);
                } else {
                    $FileAPP_page->input("Og", array("accept"=> "png,jpg,jpeg,gif", "tag" => "Og"));
                }?>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <button class="button"><?php echo $Text->item("Next");?></button>
                <button type="button" class="button" onclick="history.go(-1)"><?php echo $Text->item("Back");?></button>
            </td>
        </tr>
    </table>
</form>
</div>
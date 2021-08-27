<?php
$FileAPP = new system\module\File\php\FileAPP;
$SettingAPP = new \system\module\Setting\php\SettingAPP(0);
$abbrevs = $Language->items;
?>
<div class="admin">
<h2 class="title">GLOBAL SETTINGS</h2>
<div class="error-message" id="error-message"></div>
<button type="button" class="button center block" onclick="window.open('<?php echo $Core->this_path(0,-1);?>/list', '_self')">ALL SETTINGS</button>
<form class="form" id="form" action="<?php echo $Core->query_path() . '?id=0';?>" method="post" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <th>Name</th>
            <?php foreach($abbrevs as $key=>$value){?>
            <th><?php echo $key;?></th>
            <?php } ?>
        </tr>
        
        <?php $SettingAPP->set("Title", array("page_id" => 0, "column" => "language", "type" => "text"));?>
        <?php $SettingAPP->set("Description", array("page_id" => 0, "column" => "language", "type" => "textarea"));?>
        <?php $SettingAPP->set("Keywords", array("page_id" => 0, "column" => "language", "type" => "text"));?>
        <?php $SettingAPP->set("Contact-email", array("page_id" => 0, "column" => "value", "type" => "text", "required" => true));?>
        
        <tr>
            <td>Favicon</td>
            <td colspan="100%">
                <?php if(isset($File->items["Favicon"])){
                    $FileAPP->input_edit($File->items["Favicon"]);
                } else {
                    $FileAPP->input("Favicon", array("accept"=> "png,jpg,jpeg,gif", "tag" => "Favicon"));
                }?>
            </td>
        </tr>
        
        <tr>
            <td>Og image</td>
            <td colspan="100%">
                <?php if(isset($File->items["Og"])){
                    $FileAPP->input_edit($File->items["Og"]);
                } else {
                    $FileAPP->input("Og", array("accept"=> "png,jpg,jpeg,gif", "tag" => "Og"));
                }?>
            </td>
        </tr>
        
        <tr>
            <td>HTTPS only</td>
            <td colspan="100%"><?php $Form->on_off("HTTPS", $Setting->_("HTTPS", array("type" => "value", "page_id" => "0", "link_id" => "0")));?></td>
        </tr>
        
        <tr>
            <td>XML Sitemap</td>
            <td colspan="100%"><?php 
                    $Form->on_off("SITEMAP", $Setting->_("SITEMAP", array("type" => "value", "page_id" => "0", "link_id" => "0")));                ?>
                url: <?php echo $Core->domain() . $Core->url();?>Setting/query/sitemap
            </td>
        </tr>
        
        <tr>
            <td>Robots noindex</td>
            <td colspan="100%"><?php $Form->on_off("NOINDEX", $Setting->_("NOINDEX", array("type" => "value", "page_id" => "0", "link_id" => "0")));?></td>
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
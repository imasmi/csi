<?php
if($Setting->_("SITEMAP", array("type" => "value", "page_id" => "0", "link_id" => "0")) == 1){
    // Send the headers
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php 
foreach($PDO->query("SELECT id FROM " . $Page->table . " ORDER by id ASC") as $id=>$page){
    $abbreviations = $Language->items;
?>
    <url>
        <loc><?php echo $Core->domain() . $Page->url($page["id"], $abbreviations[key($abbreviations)]);?></loc>
        <?php 
            if(count($abbreviations) > 1){
                foreach ($abbreviations as $lang => $abbrev){
            ?>
                <xhtml:link rel="alternate" hreflang="<?php echo $abbrev;?>" href="<?php echo $Core->domain() . $Page->url($page["id"], $abbrev);?>"/>
        <?php
                }
            }
        ?>
        <priority>0.8</priority>
    </url>
<?php 
}
?>
</urlset>
<?php }?>
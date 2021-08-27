<?php 
if($User->_() != "admin"){require_once($Core->doc_root() . "/system/module/Text/php/TextAPP.php");}
$TextAPP = new \system\module\Text\php\TextAPP;
$search = array();
$setting_search = $PDO->prepare("SELECT * FROM " . $Setting->table . " WHERE fortable IS NULL AND " . $Language->_() . " LIKE :find");
$setting_search->execute(array("find" => "%" . $_GET["find"] . "%"));
if($setting_search->rowCount() > 0){
    foreach($setting_search as $set_find){
        if($set_find["page_id"] != 0){$search[$set_find["page_id"]] = strip_tags($set_find[$Language->_()]);}
    }
}

$text_search = $PDO->prepare("SELECT * FROM " . $Text->table . " WHERE fortable IS NULL AND " . $Language->_() . " LIKE :find");
$text_search->execute(array("find" => "%" . $_GET["find"] . "%"));
if($text_search->rowCount() > 0){
    foreach($text_search as $txt_find){
        if($txt_find["page_id"] != 0){$search[$txt_find["page_id"]] = strip_tags($txt_find[$Language->_()]);}
    }
}
?>
<ul id="search-page">
<?php 
    foreach($search as $page_id => $text){
        $Setting = new \system\module\Setting\php\Setting($page_id);
        ?>
        <li>
            <a href="<?php echo $Page->url($page_id);?>">
                <h2 class="search-title"><?php echo $Setting->_("Title");?></h2>
                <div class="search-text"><?php echo $TextAPP->slice($text, array("search"=> $_GET["find"], "start" => -2, "length" => 30));?></div>
            </a>
        </li>
        <?php
    }
?>
</ul>
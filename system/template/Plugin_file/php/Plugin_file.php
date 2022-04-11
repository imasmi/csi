<?php
namespace plugin\Plugin_file;
use \module\Text\Text as Text;
use \module\File\File as File;
use \module\Setting\Setting as Setting;

class Plugin_file{
    public function __construct($id=false){
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $Page;
        $this->Page = $Page;
        global $Setting;
        $this->Setting = $Setting;
		global $Text;
		$this->Text = $Text;
		global $File;
		$this->File = $File;
		require_once(\system\Core::doc_root() . "/system/module/Listing/php/ListingAPP.php");
        $this->ListingAPP = new \module\Listing\ListingAPP;
        $this->table = $File->table;
        $this->tag = "plugin_file"; //Database tag for file table
        $this->plugin = "Plugin_file"; //Full name of the plugin
        $this->page_id = 0;
		$this->id = $id;
		$this->items = $this->items();
    }

// General functions 
    public function items(){
        $items = array();
        foreach($this->PDO->query("SELECT * FROM " . $this->table . " WHERE `plugin` = '" . $this->plugin . "' AND  `tag`='" . $this->type . "' AND page_id='" . $this->page_id . "' ORDER by `row` ASC, id DESC") as $file){
            $items[$file["id"]] = $file;
        }
        return $items;
    }

// Listing functions    
    public function item($item){
        $id = is_int($item) ? $item : $item["id"];
        $Setting = new Setting($id, array("page_id" => $id, "fortable" => $this->table, "plugin" => $this->plugin));
        $Text = new Text($id, array("page_id" => $id, "fortable" => $this->table, "plugin" => $this->plugin));
        $File = new File($id, array("page_id" => $id, "fortable" => $this->table, "plugin" => $this->plugin));
        ?>
            <div class="plugin_file-item">
                <div class="plugin_file-file"><?php echo $File->_("Plugin_file file");?></div>
        		<div class="plugin_file-content">
        			<h1 class="plugin_file-title"><?php echo $this->Setting->_("plugin_file");?></h1>
        			<div class="plugin_file-date"><?php echo date("F d,Y", strtotime($page["created"]));?></div>
        			<div class="plugin_file-text"><?php echo $Text->_("Plugin_file text");?></div>
        		</div>
            </div>
        <?php
    }
    
    public function listing(){
        ?>
        <div class="plugin_file">
            <div class="plugin_file-listing">
                <?php 
                    foreach($this->ListingAPP->page_slice($this->items) as $id=>$item){
                        $this->item($item);
                    }
                ?>
            </div>
            <div class="plugin_file-pagination"><?php $this->ListingAPP->pagination(count($this->items));?></div>
        </div>
        <?php
    }
    
    public function _(){
        if($this->id !== false){
            echo $this->item($this->id);
        } else { 
            echo $this->listing();
        }
    }
}
?>
<?php
namespace plugin\Plugin_page\php;
use \system\module\Text\php\Text as Text;
use \system\module\File\php\File as File;
use \system\module\Setting\php\Setting as Setting;

class Plugin_page{
    public function __construct($id=false){
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $Page;
        $this->Page = $Page;
        global $User;
        $this->User = $User;
        global $Setting;
        $this->Setting = $Setting;
		global $Text;
		$this->Text = $Text;
		global $File;
		$this->File = $File;
		if($User->_() != "admin"){require_once($Core->doc_root() . "/system/module/Listing/php/ListingAPP.php");}
        $this->ListingAPP = new \system\module\Listing\php\ListingAPP;
        $this->table = $Query->table('page');
        $this->tag = "plugin_page"; //Database tag for page table
        $this->plugin = "Plugin_page"; //Full name of the plugin
        $this->link_id = 0;
		$this->id = $id;
		$this->items = $this->items();
    }

// General functions 
    public function items(){
        $items = array();
        foreach($this->PDO->query("SELECT * FROM " . $this->table . " WHERE plugin='" . $this->plugin . "' AND tag='" . $this->tag . "' ORDER by `row` ASC, id ASC") as $id=>$page){
            $items[$page["id"]] = $page;
        }
        return $items;
    }

// Listing functions    
    public function item($page){
        $id = $page["id"];
        $Setting = new Setting($id, array("plugin" => $this->plugin));
        $Text = new Text($id, array("plugin" => $this->plugin));
        $File = new File($id, array("plugin" => $this->plugin));
        ?>
            <div class="plugin_page-item">
                <div class="plugin_page-file"><?php echo $File->_("Plugin_page file");?></div>
        		<div class="plugin_page-content">
        			<h1 class="plugin_page-title"><?php echo $Text->_("Title", array("setting" => true));?></h1>
        			<div class="plugin_page-date"><?php echo date("F d,Y", strtotime($page["created"]));?></div>
        		</div>
            </div>
        <?php
    }
    
    public function listing(){
        ?>
        <div class="plugin_page">
            <div class="plugin_page-listing">
                <?php 
                    foreach($this->ListingAPP->page_slice($this->items) as $id=>$page){
                        $this->item($page);
                    } 
                ?>
            </div>
            <div class="plugin_page-pagination"><?php $this->ListingAPP->pagination(count($this->items));?></div>
        </div>
        <?php
    }

    public function _(){
        if($this->Page->tag == "plugin_page"){
            echo $this->item($this->Page->_("*"));
        } else { 
            echo $this->listing();
        }
    }
}
?>
<?php
namespace module\Page;
use \module\Setting\Setting as Setting;

class Menu{

    public function __construct($menu, $array = array("submenu" => true, "mobile-open" => false, "mobile-close" => "X", "ul-class" => "top-menu", "query" => false)){
        global $PDO;
        $this->PDO = $PDO;
        global $Plugin;
        $this->Plugin = $Plugin;
        global $Language;
        $this->Language = $Language;
        global $Page;
        $this->Page = $Page;
        $this->arr = $array;
        $this->menu = $menu;
        $this->like = $this->like();
        $top_link_query = isset($array["query"]) && $array["query"] !== false ? $array["query"] : "SELECT link_id FROM " . $Page->table . " WHERE " . $this->like . " ORDER by link_id ASC";
        $top_link_id = $this->PDO->query($top_link_query)->fetch();
        $this->link_id = $top_link_id["link_id"]; // start link_id for top menu pages
    }

    public function menu_name($id, $setting){
        return $setting != "" ? $setting : $id;
    }

    private function like(){
        if(is_array($this->menu)){
            $like = "(";
            for($a = 0; $a < count($this->menu); ++$a){
                $like .= "menu LIKE '%" . $this->menu[$a] . "%'";
                if($a != count($this->menu) - 1){ $like .= " OR ";}
            }
            $like .= ")";
        } else {
            $like = "menu LIKE '%" . $this->menu . "%'";
        }
        return $like;
    }

    public function select($link_id){
        $pages = array();
        $query = isset($this->arr["query"]) && $this->arr["query"] !== false && $link_id == $this->link_id ? $this->arr["query"] : "SELECT id, link_id, menu FROM " . $this->Page->table . " WHERE " . $this->like . " AND link_id='" . $link_id . "' AND theme LIKE '" . $GLOBALS["Theme"]->active . "' ORDER by `row` ASC, id ASC";
        foreach($this->PDO->query($query) as $key=>$page){
            $multiple = explode(",", $page["menu"]);
            if(count($multiple) > 1){
                if(is_array($this->menu)){
                    if(!empty(array_intersect($multiple, $this->menu))){$pages[$page["id"]] = $page;}
                } else {
                    if(in_array($this->menu, $multiple)){$pages[$page["id"]] = $page;}
                }
            } else {
                $pages[$page["id"]] = $page;
            }
        }
        return $pages;
    }

    public function item($key, $page){
            $Setting = new Setting($key);
            $menu_name = $Setting->_("Menu", array("page_id" => $page["id"]));
            $subs = $this->select($page["id"]);
            ?>
            <li class="<?php echo ($page["link_id"] != $this->link_id) ? 'sub-item' : 'menu-item';?><?php if($key == $this->Page->id()){echo ' active';}; if(count($subs) > 0){ echo ' with-sub';}?>">
                <a href="<?php echo $this->Page->url($page["id"]);?>" title="<?php echo $Setting->_("Title", array("type" => "", "page_id" => $key));?>"/><?php echo $this->menu_name($key, $menu_name);?></a>
                <?php if(isset($this->arr["submenu"]) && $this->arr["submenu"] === true){$this->pages($page["id"]);}?>
            </li>
        <?php
    }

    public function pages($link_id=false){
        $link_id = $link_id !== false ? $link_id : $this->link_id;
        if($link_id == $this->link_id || $this->arr["submenu"] === true){
            $pages = $this->select($link_id);
            if(count($pages) > 0){ ?>
                <ul class="<?php echo ($link_id != $this->link_id) ? 'sub-menu' : ((isset($this->arr["class"])) ? $this->arr["class"] : 'top-menu');?>">
                <?php foreach($pages as $key=>$page){$this->item($key, $page);}?>
                </ul>
                <?php
            }
        }
    }

    public function _(){
    $menu_id = 'menu-' . $this->menu;
    ?>
        <div class="menu<?php if(isset($this->arr["mobile-open"]) && $this->arr["mobile-open"] !== false){ echo ' mobile-menu';}?>" id="<?php echo $menu_id;?>">
            <?php if(isset($this->arr["mobile-open"]) && $this->arr["mobile-open"] !== false){?><div class="mobile-open select-none"><?php echo $this->arr["mobile-open"];?></div><?php } ?>
            <div class="menu-content">
                <?php if(isset($this->arr["mobile-close"]) && $this->arr["mobile-open"] !== false){?><div class="mobile-close select-none mobile-tap"><?php echo $this->arr["mobile-close"];?></div><?php } ?>
                <?php $this->pages();?>
            </div>
        </div>
    <?php }
}
?>

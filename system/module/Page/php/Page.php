<?php
namespace system\module\Page\php;
use \system\module\Setting\php\Setting as Setting;

class Page{
    //Array possible values (table => "string")
    public function __construct($page_id = 0, $array = array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Core;
        $this->Core = $Core;
        global $Query;
        $this->Query = $Query;
        global $Module;
        $this->Module = $Module;
        global $Plugin;
        $this->Plugin = $Plugin;
        global $Language;
        $this->Language = $Language;
        $this->table = (isset($array["table"])) ? $array["table"] : $Query->table("page");
        $this->items = $this->items($page_id);
        $this->arr = $array;
        // Change session language if page of other language is opened
        if($this->check_language() !== false && $this->check_language() != $this->Language->_()){global $Cookie; $Cookie->set("language", $this->check_language());} 
        $this->folder = "/web/page";
		$this->doc_root = $Core->doc_root() . $this->folder;
        $this->id = $page_id != 0 ? $page_id : $this->id();
        $this->tag = $this->id != 0 ? $this->items[$this->id]["tag"] : null;
        $this->type = $this->id != 0 ? $this->items[$this->id]["type"] : null;
        $this->current_file = $this->current_file();
        if($this->current_file === false && $this->id == 0){ http_response_code(404);}// send response code 404 if page is not found
    }
    
    public function items($page_id){
        $items = array();
        $links = $this->Core->links;
        $end_link = end($links);
        if($page_id != 0){
            $where = " id='" . $page_id . "'";
        } elseif(!isset($_GET["url"]) || $_GET["url"] == ""){
            $where = "type='homepage'"; 
        } elseif($this->Language->_() !== false && isset($end_link)) {
            $where = $this->Language->_() . "='" . $end_link . "' OR id='" . $end_link . "'";
        } else {
            $where = "id='0'";
        }
        foreach($this->PDO->query("SELECT * FROM " .  $this->table . " WHERE " . $where . " ORDER BY link_id ASC, id ASC", \PDO::FETCH_ASSOC) as $page){
            $items[$page["id"]] = $page;
        }
        
        return $items;
    }
    
    public function id(){
        if($_GET["url"] === ""){
            return $this->homepage();
        } else {
            $links = $this->Core->links();
            $out_id = 0;
            foreach($this->items as $id=>$page){
                $cnt = 0;
                foreach($this->scheme($id) as $key=>$value){
                    if($links[$cnt] != $key && mb_strtolower($links[$cnt]) != mb_strtolower($value[$this->Language->_()])){break;}
                    if($id == $key){return $id;}
                    $cnt++;
                }
            }
        }
        return 0;
    }
    
    //array possible values: id => int
    public function _($column = "id", $array = array()){
        $id = isset($array["id"]) ? $array["id"] : $this->id;
        $page = isset($this->items[$id]) ? $this->items[$id] : $this->Query->select($id, "id", $this->table);
        return $column == "*" || $page == false ? $page : $page[$column];
    }
    
    public function scheme($id=false){
        $id = $id === false ? $this->id : $id;
        $page = isset($this->items[$id]) ? $this->items[$id] : $this->Query->select($id, "id", $this->table);
        if(!empty($page)){
            $output[$id] = $page;
            if($page["link_id"] != "0"){
                $output = array_replace($this->scheme($page["link_id"]), $output);
            }
            return $output;
        } else {
            return false;
        }
    }
    
    public function path($id, $dir = false){
        $output = array();
        foreach($this->scheme($id) as $id => $page){
            if($page["filename"] != ""){
                $output[] = $page["filename"];
            }
        }
        if($dir !== false){unset($output[count($output) - 1]);}
        return rtrim(implode('/', $output), '/');
    }
    
    public function map($id, $separator = " > "){
        if($id == 0){ return "Global";}
        $scheme = $this->scheme($id);
        if($scheme === false){return "Non-exists";}
        $output = array();
        foreach($scheme as $key => $page){
            $Setting = new Setting($key);
            if($Setting->_("Title", array("page_id" => $key)) !== false ){
                $output[] = $Setting->_("Title", array("page_id" => $key));
            } else {
                $output[] = $key;
            }
        }
        return rtrim(implode($separator, $output), $separator);
    }
    
    public function homepage(){
        return $this->Query->select("homepage", "type", $this->table)["id"];
    }
    
    public function url($id, $language = false){
        $lang = ($language !== false) ? $language : $this->Language->_();
        $page = isset($this->items[$id]) ? $this->items[$id] : $this->Query->select($id, "id", $this->table);
        $link_name = !empty($page[$lang]) ? $page[$lang] : $page["id"];
        if(strpos($link_name, "http") !== false){
            $output = $link_name;
        } elseif($page["id"] == $this->homepage()){
            $output = $this->Core->url();
        } else {
            $scheme = $this->scheme($id);
            $output = $this->Core->url();
            if(count($scheme) > 1 || $scheme[key($scheme)]["type"] != "homepage"){
                foreach($scheme as $key => $value){
                    $output .= (!empty($value[$lang]) ? $value[$lang] : $key) . '/';
                }
                $output = rtrim($output, '/');
            }
        }
        return $output;
    }
    
    public function http($link){
        return strpos($link, "http") !== false ? $link : "http://" . $link;
    }
    
    public function current_file(){
        $link = $this->Core->links;
        $loc_dir = in_array("query", $link) ? "/" : "/page/";
        $web_index = false;
    
        $module_inside = $this->Module->_();
        #CHECK IF WE ARE IN SOME MODULE IDNEX PAGE
        if($module_inside !== false){
            unset($link[0]);
            $module_page = (count($link) > 0) ? implode("/", $link) : "index";
            $web_index = $this->Core->path_resolve("/system/module/" . $module_inside . $loc_dir . $module_page . ".php");
        }
        
        #CHECK IF WE ARE IN SOME PLUGIN PAGE
        $check_plugin = $this->Plugin->_();
        if($check_plugin !== false && $web_index === false){
            unset($link[0]);
            $plugin_page = (count($link) > 0) ? implode("/", $link) : "index";
            $web_index = $this->Core->path_resolve("/plugin/" . $check_plugin . $loc_dir . $plugin_page . ".php");
        }
        
        #CHECK IF FILE EXISTS IN WEB FOLDER BY PATH
        if($web_index === false && $this->id != 0){ $web_index = $this->Core->path_resolve("/web" . $loc_dir . $this->path($this->id) . ".php");}
        
        #CHECK IF FILE EXISTS IN WEB FOLDER BY URL
        if($web_index === false){ $web_index = $this->Core->path_resolve("/web" . $loc_dir . $_GET["url"] . ".php");}
    	
        return $web_index;
    }
    
    public function check_language(){
        $links = $this->Core->links();
        if(count($links) > 0 && $links[0] != ""){
            if($this->Module->_() === false && $this->Plugin->_() === false){
                foreach($this->items as $id=>$page){
                    foreach($this->Language->items as $lang => $abbrev){
                        if($page[$abbrev] == $links[0]){return $abbrev;}
                    }
                }
            }
        }
        return false;
    }
    
    public function head(){ 
        global $Setting;
        global $File;
        ?>
        <title><?php echo (!empty($Setting->_("Title",  array("type" => $this->Language->_(), "page_id" => $this->id)))) ? $Setting->_("Title",  array("type" => $this->Language->_(), "page_id" => $this->id())) : $Setting->_("Title", array("type" => $this->Language->_(), "page_id" => "0"));?></title>
        <?php if(isset($File->items["Favicon"]) && $File->items["Favicon"]["path"] !== ""){?><link rel="icon" href="<?php echo $this->Core->url() . $File->items["Favicon"]["path"];?>" sizes="32x32"><?php }?>
        <?php if($Setting->_("NOINDEX", array("page_id" => 0, "link_id" => 0)) == 1){?>
            <meta name="robots" content="noindex, nofollow" />
        <?php } else {?>
            <meta name="robots" content="index,follow"/>
        <?php } ?>
        <meta name="description" content="<?php echo $Setting->_("Description");?>">
        <meta name="keywords" content="<?php echo $Setting->_("Keywords");?>">
        <meta property="og:title" content="<?php echo $Setting->_("Title");?>" />
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?php echo $this->Core->domain() . $_SERVER["REQUEST_URI"];?>" />
        <meta property="og:description" content="<?php echo $Setting->_("Description");?>"/>
        <?php 
            $og = $File->items["Og"]["path"];
            if($og){
            $info = pathinfo($og);
            foreach($File->imagesize as $size => $pixels){
                $new_name = $info["dirname"] . '/' . $info["filename"] . '_' . $size . '.' . $info["extension"];
                if($pixels > 1079 && file_exists($this->Core->doc_root() . '/' . $new_name)){
                    $og = $new_name;
                    break;
                }
            }
            $og_info = getimagesize($this->Core->doc_root() . '/' . $og);
        ?>
            <meta property="og:image" content="<?php echo $this->Core->domain() . "/" . $og;?>" />
            <meta property="og:image:type" content="<?php echo $og_info["mime"];?>" />
            <meta property="og:image:width" content="<?php echo $og_info[0];?>" />
            <meta property="og:image:height" content="<?php echo $og_info[1];?>" />
            <?php } ?>
    <?php
    }
}

$Page = new Page;
?>
<?php
namespace system\module\Plugin\php;

class Plugin{
    
    public function __construct($plugins){
        global $Core;
        $this->Core = $Core;
        global $User;
        $this->User = $User;
        $this->items = $plugins;
        $this->doc_root = $Core->doc_root() . '/plugin';
    }
    
    public function _(){
        $link = $this->Core->links();
        foreach($this->items as $plugin => $value){
            if(mb_strtolower($plugin) == mb_strtolower($link[0])){
                return $plugin;
            }
        }
        return false;
    }
    
    public function index_page($plugin){
        $link = $this->doc_root . '/' . $plugin . '/page/admin/index.php';
        if(file_exists($link)){
            return $this->Core->url() . $plugin . "/admin/index";
        } else {
            return false;
        }
    }
    
    public function object($class = false, $parameter=false){
        $object_name = ($class !== false) ? $class : $this->_();
        $object = "\plugin\\" . $this->_() . "\php\\" . $object_name;
        return ($parameter !== false) ? new $object($parameter) : new $object;
    }
    
    public function button($plugin, $array = array()){
        if($this->User->role == "admin"){?>
            <button class="button plugin-button block center" onclick="window.open('<?php echo $this->Core->url() . $plugin;?>/admin/index', '_self')"><?php echo isset($array["text"]) ? $array["text"] : $plugin;?></button>
        <?php }
    }
}

$Plugin = new Plugin($plugins);
?>
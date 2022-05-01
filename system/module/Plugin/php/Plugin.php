<?php
namespace module\Plugin;

class Plugin{

    public function __construct(){
        $this->items = file_exists(\system\Core::doc_root() . "/web/ini/plugin.ini") ? parse_ini_file(\system\Core::doc_root() . "/web/ini/plugin.ini", true) : array();
        $this->doc_root = \system\Core::doc_root() . '/plugin';
    }

    public function _(){
        $link = \system\Core::links();
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
            return \system\Core::url() . $plugin . "/admin/index";
        } else {
            return false;
        }
    }

    public function object($class = false, $parameter=false){
        $object_name = ($class !== false) ? $class : $this->_();
        require_once(\system\Core::doc_root() . "/plugin/" .  $this->_() . "/php/" . $object_name . ".php");
        $object = "\plugin\\" . $this->_() . "\\" . $object_name;
        return ($parameter !== false) ? new $object($parameter) : new $object;
    }

    public function button($plugin, $array = array()){
        if(\module\User\User::group("admin")){?>
            <button class="button plugin-button block center" onclick="window.open('<?php echo \system\Core::url() . $plugin;?>/admin/index', '_self')"><?php echo isset($array["text"]) ? $array["text"] : $plugin;?></button>
        <?php }
    }
}
?>

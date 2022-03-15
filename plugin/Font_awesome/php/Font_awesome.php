<?php
namespace plugin\Font_awesome;
use \module\Setting\Setting as Setting;

class Font_awesome{
    public function __construct($page_id = false, $array = array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Page;
        $this->Page = $Page;
        global $User;
        $this->User = $User;
        global $Setting;
        $this->Setting = $page_id !== false ? new Setting($page_id, $array) : $Setting;
        $this->page_id = $page_id !== false ? $page_id : $Page->id;
        $this->plugin = "Font_awesome";
        $this->table = $Setting->table;
        $this->items = $this->items();
    }
    
    public function items(){
        $icons = str_replace(array("\n", "\r"), "", file_get_contents(\system\Core::doc_root() . "/plugin/". $this->plugin . "/icon/icon.csv"));
        return explode(",", $icons);
    }
    
    public function listing(){
        foreach($this->items as $item){
        ?>
            <div class="column-2 fa-item padding-10"><i class="<?php echo $item;?>"></i><?php echo $item;?></div>
        <?php
        }
    }
    
    public function select($item){
    ?>
        <div class="inline-block fa-item padding-10 text-center"><i class="<?php echo $item;?>" onclick="S.post('<?php echo \system\Core::url();?>Setting/query/admin/update-setting',{'page_id': '<?php echo $_POST["page_id"];?>', 'link_id': '', fortable: '<?php echo $_POST["fortable"];?>', 'plugin':'<?php echo $this->plugin;?>', 'tag':'<?php echo $_POST["tag"];?>','value':'<?php echo $item;?>'},function(data){S('#<?php echo $_POST["tag"];?>-<?php echo $_POST["page_id"];?>').setAttribute('class', '<?php echo $item;?>'); S.popupExit();});"></i></div>
    <?php
    }
    
    public function _($tag, $array = array()){
        $icon = $this->Setting->_($tag, array("plugin" => $this->plugin) + $array) ? $this->Setting->_($tag, array("plugin" => $this->plugin) + $array) : "fas fa-camera";
        $page_id = isset($array["page_id"]) ? $array["page_id"] : $this->page_id;
        $fortable = isset($array["fortable"]) ? $array["fortable"] : $this->Setting->fortable;
        ?>
        <i id="<?php echo $tag;?>-<?php echo $page_id;?>" class="<?php echo $icon;?>" <?php if($this->User->group("admin")){?>ondblclick="S.popup('<?php echo \system\Core::url() . $this->plugin;?>/query/select', {page_id: '<?php echo $page_id;?>', 'tag' : '<?php echo $tag;?>', fortable: '<?php echo $fortable;?>'})" <?php } ?>></i>
        <?php
    }
}
?>
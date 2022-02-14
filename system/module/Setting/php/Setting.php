<?php
namespace module\Setting;

class Setting{
    //Array possible values (table => "string", "fortable" => string, "plugin" => string, page_id => int (to select additional page settings, 0 is for global settings)
    public function __construct($page_id=false, $array = array()){
        global $PDO;
        $this->PDO = $PDO;
        global $Language;
        $this->Language = $Language;
        global $Page;
        $this->Page = $Page;
        global $Text;
        $this->Text = $Text;
        $this->page_id = $page_id !== false ? $page_id : $Page->_();
        $this->table = (isset($array["table"])) ? $array["table"] : \system\Data::table("setting");
        $this->fortable = isset($array["fortable"]) ? $array["fortable"] : NULL;
        $this->plugin = isset($array["plugin"]) ? $array["plugin"] : NULL;
        $this->arr = $array;
        $this->items = $this->items($this->page_id);
        #HTTPS only if selected
        if($this->_("HTTPS", "value", "0", "0") == 1 && $_SERVER["REQUEST_SCHEME"] !== "https"){
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit;
        }
    }

    public function items($page_id, $link_id = false){
        $settings = array();
        $fortable = ($this->fortable === NULL) ? "AND fortable IS NULL" : "AND fortable='" . $this->fortable . "'";
        if($link_id !== false){
            $query = "SELECT * FROM " .  $this->table . " WHERE page_id='" . $page_id . "' AND link_id='" . $link_id . "' " . $fortable . " ORDER by `row` ASC, id ASC";
        } else {
            $page_id_select = isset($this->arr["page_id"]) ?  " ((page_id='" . $this->arr["page_id"] . "' AND link_id=0) OR page_id='" . $page_id . "') " : " page_id='" . $this->page_id . "' ";
            $query = "SELECT * FROM " .  $this->table . " WHERE " . $page_id_select . $fortable . " ORDER by page_id DESC, `row` ASC, id ASC";
        }

        foreach($this->PDO->query($query, \PDO::FETCH_ASSOC) as $setting){
            $settings[$setting["id"]] = $setting;
            if(isset($setting["tag"]) && (!isset($settings[$setting["tag"]])) || $setting["page_id"] == $page_id){$settings[$setting["tag"]] = $setting;}
        }
        return $settings;
    }


    public function update_setting($setting, $field, $array){?>
        <?php
        $style = 'class="Setting"';
        $json_setting = "{page_id: '" . $setting["page_id"] . "', link_id: '" . $setting["link_id"] . "', tag:'" . $setting["tag"] . "', plugin: '" . (isset($array["plugin"]) ? $array["plugin"] : $this->plugin) . "', fortable: '" . (isset($array["fortable"]) ? $array["fortable"] : $this->fortable) . "', " . $field . ": " . ($array["update-input"] == "checkbox" ? "(this.checked === true ? '1' : '')" : "this.value") . "}";
        
        if($array["update-input"] == "text" || $array["update-input"] == "number" || $array["update-input"] == "checkbox"){
        ?>
            <input type="<?php echo $array["update-input"];?>" id="setting-edit-<?php echo $setting["id"];?>"
            <?php echo $style;?>
            <?php if($array["update-input"] != "checkbox"){?> value="<?php echo $setting[$field];?>" <?php } elseif($setting[$field] == "1") { ?> checked <?php } ?>
            onchange="S.post('<?php echo \system\Core::url();?>Setting/query/admin/update-setting', <?php echo $json_setting;?>, function(data){if(data != 'done'){S.popup(data);}})"/>
        <?php
        } elseif($array["update-input"] == "textarea"){
        ?>
            <textarea id="setting-edit-<?php echo $setting["id"];?>" <?php echo $style;?> onchange="S.post('<?php echo \system\Core::url();?>Setting/query/admin/update-setting', <?php echo $json_setting;?>, function(data){if(data != 'done'){S.popup(data);}})"><?php echo $setting[$field];?></textarea>
        <?php
        }
    }

    public function id($id, $array=false){
        if(is_numeric($id)){return $id;}

        if(isset($array["page_id"]) || isset($array["link_id"]) || isset($array["plugin"])){
            $page_id = isset($array["page_id"]) && is_numeric($array["page_id"])? $array["page_id"] : $this->page_id ;
            $settings = ($page_id != $this->page_id || (isset($array["link_id"]) && is_numeric($array["link_id"]))) ? $this->items($page_id, (isset($array["link_id"]) ? $array["link_id"] : false)) : $this->items;

            foreach($settings as $setting_id => $item){
                if($item["tag"] == $id && ($item["page_id"] == $page_id || isset($this->arr["page_id"]) && $this->arr["page_id"] == $item["page_id"]) && (!isset($array["plugin"]) || $item["plugin"] == $array["plugin"])){
                    if(!isset($this->items[$item["id"]])){$this->items[$item["id"]] = $item;}
                    return $item["id"];
                }
            }
        } elseif(isset($this->items[$id])){
            return $this->items[$id]["id"];
        }
        return 0;
    }

    //Array possible values (column=>single database column or * for all (return type), page_id => int (if not set, the current page_id will be applied), link_id=>int, "plugin" => string,  "update-input" => (text|number|textarea|checkbox), "update-column" => value|false (if set to value will make value column updater))
    public function _($tag, $array=array()){
        $id = $this->id($tag, $array);
        $setting = isset($this->items[$id]) ? $this->items[$id] : array();

        if(isset($array["update-input"]) && \module\User\User::group("admin")){
            $update = "";
            if(empty($setting)){
                $setting = array(
                    "id" => 0,
                    "page_id" => isset($array["page_id"]) && is_numeric($array["page_id"]) ? $array["page_id"] : $this->page_id,
                    "link_id" => isset($array["link_id"]) && is_numeric($array["link_id"]) ? $array["link_id"] : "0",
                    "tag" => $tag,
                    "value" => ""
                );
                foreach($this->Language->items as $name => $code){
                    $setting[$code] = "";
                }
            }
            if(isset($array["update-column"]) && $array["update-column"] == "value"){
                $update = $this->update_setting($setting, "value", $array);
            } else {
                foreach($this->Language->items as $lang => $abbrev){
                    $update .= $lang;
                    $update .= $this->update_setting($setting, $abbrev, $array);
                }
            }
            return $update;
        } else {
            if(isset($array["column"]) && $array["column"] != ""){
                if($array["column"] == "*"){
                    return $setting;
                } else {
                    return isset($setting[$array["column"]]) ? $setting[$array["column"]] : null;
                }
            } else {
                if(isset($setting[\module\Language\Language::_()])){
                    return $setting[\module\Language\Language::_()];
                } else {
                    return isset($setting["value"]) ? $setting["value"] : null;
                }
            }
        }
    }
}
?>

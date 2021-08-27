<?php
namespace system\module\Setting\php;

class SettingAPP extends Setting{
    
    public function set_fields($post){
        $array = array();
        foreach($post as $key=>$value){
            if($key != "page_id" && $key != "link_id"){
                $key_parts = explode("_", $key);
                if(in_array($key_parts[count($key_parts) - 1], $this->Language->items)){unset($key_parts[count($key_parts) - 1]);}
                $name = implode("_", $key_parts);
                if(!in_array($name, $array)){$array[] = $name;}
             }
        }
        return array_unique($array);
    }
    
    //array values
    //column: *|value|language
    //page_id: page id for setting
    //link_id: link_id for setting
    //type: form element type (text, textarea, checkbox, radio button and etc)
    //required: true if field is required
    public function set($field, $array=array("column" => '*', "page_id" => 0, "link_id" => 0, "type" => "text", "required" => false)){
        $page_id = (isset($array["page_id"])) ? $array["page_id"] : 0;
        $link_id = (isset($array["link_id"])) ? $array["link_id"] : 0;
        $column = (isset($array["column"])) ? $array["column"] : "*";
        $type = (isset($array["type"])) ? $array["type"] : "text";
        $required = (isset($array["required"]) && $array["required"] !== false) ? "required" : "";
        
        $set = $this->_($field, array("column" => "*", "page_id" => $page_id, "link_id" => $link_id));
    ?>
        <tr>
            <td><?php echo $field;?></td>
            
            <?php if($column == "value" || $column == "*"){?>
            <td>
                <?php
                if($type == "textarea"){?>
                    <textarea name="<?php echo $field;?>" id="<?php echo $field;?>" <?php echo $required;?>><?php echo (isset($set["value"])) ? $set["value"] : "";?></textarea>
                <?php } else {?>
                    <input type="text" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo (isset($set["value"])) ? $set["value"] : "";?>"/>
                <?php } ?>
            </td>
            <?php } ?>
            
            <?php if($column == "language" || $column == "*"){
                $abbrevs = $this->Language->items;
                foreach($abbrevs as $key=>$value){?>
                    <td>
                    <?php if($type == "textarea"){?>
                        <textarea type="<?php echo $type;?>" name="<?php echo $field;?>_<?php echo $value;?>" id="<?php echo $field;?>_<?php echo $value;?>" <?php echo $required;?> placeholder="<?php echo $key . " " . $field;?>"><?php echo (isset($set[$value])) ? $set[$value] : "";?></textarea>
                    <?php } else {?>
                        <input type="<?php echo $type;?>" name="<?php echo $field;?>_<?php echo $value;?>" id="<?php echo $field;?>_<?php echo $value;?>" value="<?php echo (isset($set[$value])) ? $set[$value] : "";?>" <?php echo $required;?> placeholder="<?php echo $key . " " . $field;?>"/>
                    <?php } ?>
                    </td>
                <?php }?>
            <?php } ?>
        </tr>
    <?php 
    }
    
    #page_id => 4, link_id => 0, "field" => $value, "field_en" => $value, "field_bg" => $value
    #field without language ending (field_en) sets/update value column in setting table
    #can't contain blank space in the name
    public function save($post){
        $set_fields = $this->set_fields($post);
        $abbrevs = $this->Language->items;
        $page_id = (isset($post["page_id"])) ? $post["page_id"] : $this->page_id;
        $link_id = (isset($post["link_id"])) ? $post["link_id"] : 0;
        foreach($set_fields as $field){
            $check_setting = $this->_($field, array("column" => "*", "page_id" => $page_id, "link_id" => $link_id));
            $languages = array("value" => (isset($post[$field]) ? $post[$field] : null));
            $update_prepare = "";
            foreach($abbrevs as $key => $value){
                $languages[$value] = isset($post[$field . "_" . $value]) ? $post[$field . "_" . $value] : null;
                $update_prepare .= $value . "=:" . $value . ",";
            }
            
            $check = 0;
            foreach ($languages as $value){
                if($value != ""){ $check++;}
            }
            
            if($check > 0){
            if(!isset($check_setting["id"])){
                $lang_fields = implode(", ", $abbrevs);
                $lang_prepare = ":" . implode(",:", $abbrevs);
                $lang_prepare = ":" . implode(",:", $abbrevs);
                
                $plugin = $this->plugin;
                if(!in_array("plugin", $set_fields) && $plugin === NULL){
                    $get_parent = $this->PDO->query("SELECT * FROM " . ($this->fortable !== NULL ? $this->fortable : $this->Page->table) . " WHERE id='" . $page_id . "'")->fetch();
                    if(isset($get_parent["plugin"])){$plugin = $get_parent["plugin"];}
                }
                
                $insert_setting = $this->PDO->prepare("INSERT INTO " . $this->table . " (page_id, link_id, fortable, plugin, created, tag, value, " . $lang_fields . ") VALUES ('" . $page_id . "', '" . $link_id . "', " . ($this->fortable !== NULL ? "'" . $this->fortable . "'" : "NULL") . ", " . ($plugin !== NULL ? "'" . $plugin . "'" : "NULL") . ", NOW(), '" . $field . "', :value, " . $lang_prepare . ")");
                $insert_setting->execute($languages);
            } else {
                $update_setting = $this->PDO->prepare("UPDATE " . $this->table . " SET value=:value," . rtrim($update_prepare, ",") . " WHERE id='" . $check_setting["id"] . "'");
                $update_setting->execute($languages);
            }
            } else {
                if(isset($check_setting["id"])){$this->Query->remove($check_setting["id"], "id", $this->table);}
            }
        }
    }
}
?>
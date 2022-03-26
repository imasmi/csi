<?php
namespace system;

class Form{
    public static function validate($check){
        foreach($check as $key => $value){
            if($value !== false){echo '<div class="errorLine">' . $value . '</div>';}
            ?><script>S.highlight('<?php echo $key;?>')</script><?php
        }
    }

	public static function on_off($key, $value=0, $input=true){
	    $class = ($value > 0) ? "on" : "off";
	?>
	    <div class="on-off" id="on-off-<?php echo $key;?>">
	        <div class="change-on-off" onclick="<?php if($input === true){?>S('#<?php echo $key?>_switcher').value = 1;<?php } else {?>S.show('#<?php echo $key;?>');<?php } ?> S.classAdd('#<?php echo $key;?>_on_off', 'on'); S.classRemove('#<?php echo $key;?>_on_off', 'off');">ON</div>
	        <div class="change-on-off" onclick="<?php if($input === true){?>S('#<?php echo $key?>_switcher').value = 0;<?php } else {?>S.hide('#<?php echo $key;?>');<?php } ?> S.classAdd('#<?php echo $key;?>_on_off', 'off'); S.classRemove('#<?php echo $key;?>_on_off', 'on');">OFF</div>
	        <div class="switcher <?php echo $class;?>" id="<?php echo $key;?>_on_off"></div>
	    </div>
	    <?php if($input === true){?><input type="hidden" name="<?php echo $key;?>" id="<?php echo $key;?>_switcher" value="<?php echo $value;?>"/><?php } ?>
	<?php
	}

	//Array possible values: select => string, reuqired => boolean, title => string, addon => multilingual or true, addon-label => string label for the addon, onchange => javascript code,
    public static function select($name, $values, $array = array()){
        global $Language;
        $Text = new \module\Text\Text(0);
        ?>
        <select name="<?php echo $name;?>" id="<?php echo $name;?>"
        <?php if(isset($array["required"]) && $array["required"] == true){echo ' required';}?>
        <?php if(isset($array["onchange"])){?> onchange="<?php echo $array["onchange"];?>" <?php } ?>
        >
            <option value=""><?php if(isset($array["title"]) && $array["title"] !== ""){ echo $Text->item($array["title"]);} else{echo $Text->item("Select option");}?></option>
            <?php
            foreach($values as $key=>$value){
            ?>
            <option value="<?php echo $key;?>"<?php if(isset($array["select"]) && $array["select"] == $key){ echo " selected";}?>><?php echo ucfirst($value);?></option>
            <?php }?>
        </select>
    <?php
        if(isset($array["addon"]) && $array["addon"] !== false){
        ?>
            <input type="checkbox" id="<?php echo $name;?>-addon-checkbox" onclick="if(this.checked == true){S('#<?php echo $name;?>').disabled = true; S.all('.<?php echo $name;?>-addon', function(el){el.disabled = false; }); S.show('#<?php echo $name;?>-addon');} else {S('#<?php echo $name;?>').disabled = false; S.all('.<?php echo $name;?>-addon', function(el){el.disabled = true;});  S.hide('#<?php echo $name;?>-addon');}"/>
            <span><?php echo isset($array["addon-label"]) ? $array["addon-label"] : 'Create new ' . $name;?></span>

            <div id="<?php echo $name;?>-addon" class="hide">
                <?php if($array["addon"] === "multilingual"){
                    foreach($Language->items as $lang => $abbrev){?>
                    <div><?php echo $lang;?></div>
                    <input type="text" name="<?php echo $name;?>_<?php echo $abbrev?>" class="<?php echo $name;?>-addon" disabled required/>
                    <?php }
                } else { ?>
                    <input type="text" name="<?php echo $name;?>" class="<?php echo $name;?>-addon" disabled required/>
                <?php } ?>
            </div>
        <?php
        }
    }
    
    //Array possible values:
    //data => Array(key => value) data fiels for the selector,
    //items => Array(key => value) key is the id and the value is the selected value from the selected entries,
    //onchange => javascript function,
    //onremove => javascript function
    public static function multiselect( $id, $data ) {
        $cnt = 0;
        $onchange = isset($data['onchange']) ? $data['onchange'] : "";
        $onremove = isset($data['onremove']) ? $data['onremove'] : "";
    ?>
        <div id="multiselect-template-<?php echo $id;?>" class="hide">
            <select onchange="<?php echo $onchange;?>">
                <option value="">SELECT</option>
                <?php foreach($data["data"] as $key => $value) { ?>
                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                <?php } ?>
            </select>
            <button type="button" class="button remove-button-<?php echo $id;?>">-</button>
        </div>
        
        <div id="multiselect-items-<?php echo $id;?>">
            <?php 
            if (isset($data["items"])) {
                foreach ($data["items"] as $item ) {
                ?>
                <div id="multiselect-<?php echo $item;?>-<?php echo $cnt;?>" class="flex">
                    <select name="multiselect-<?php echo $id;?>-<?php echo $cnt;?>" onchange="<?php echo $onchange;?>">
                        <option value="">SELECT</option>
                        <?php foreach($data["data"] as $key => $value) { ?>
                            <option value="<?php echo $key;?>" <?php if ($key == $item) { echo 'selected';}?>><?php echo $value;?></option>
                        <?php } ?>
                    </select>
                    <button type="button" data-item-id="<?php echo $item;?>" class="button remove-button-<?php echo $item;?>" onclick="S.remove('#multiselect-<?php echo $item;?>-<?php echo $cnt;?>'); <?php echo $onremove;?>">-</button>
                </div>
                <?php
                $cnt++;
                }
                ?>
            <?php 
            } ?>
        </div>
        
        <button type="button" class="button" onclick="
        let newRow = document.createElement('div'); 
        newRow.innerHTML = S('#multiselect-template-<?php echo $id;?>').innerHTML;
        let newId = `multiselect-<?php echo $id;?>-${S('#multiselect-counter-<?php echo $id;?>').value}`;
        newRow.setAttribute('id', newId);
        newRow.setAttribute('class', 'flex');
        newRow.querySelector('select').setAttribute('name', newId);
        newRow.querySelector('.remove-button-<?php echo $id;?>').setAttribute('onclick', `S.remove('#${newId}'); <?php echo $onremove;?>`);
        S('#multiselect-items-<?php echo $id;?>').appendChild(newRow);
        S('#multiselect-counter-<?php echo $id;?>').value = Number(S('#multiselect-counter-<?php echo $id;?>').value) + 1;
        ">+</button>
        <input type="hidden" id="multiselect-counter-<?php echo $id;?>" name="multiselect-counter-<?php echo $id;?>" value="<?php echo $cnt;?>"/>
    <?php
    }

	public static function created($name, $value="0000-00-00 00:00:00"){
        ?>
        <input type="date" id="<?php echo $name;?>_date" value="<?php echo date("Y-m-d", strtotime($value));?>" onchange="$('#<?php echo $name;?>').val(this.value + ' ' + $('#<?php echo $name;?>_time').val())"/>
		<input type="time" id="<?php echo $name;?>_time" value="<?php echo date("H:i:s", strtotime($value));?>" onchange="$('#<?php echo $name;?>').val($('#<?php echo $name;?>_date').val() + ' ' + this.value)"/>
		<input type="hidden" name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>"/>
    <?php
    }
}
?>

<?php
namespace plugin\Select;

class Select {

    //data values: name => string, value => string, output => string
    public static function item($data){
    ?>
        <div class="select-item" onclick="
        document.getElementById('<?php echo $data["name"];?>-data').value = '<?php echo $data["output"];?>';
	    document.getElementById('<?php echo $data["name"];?>').value = '<?php echo $data["value"];?>';
	    document.getElementById('<?php echo $data["name"];?>-list').innerHTML = '';"><?php echo $data["output"];?></div>
    <?php
    }

    public static function limit(){
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $per_page = isset($_GET["per-page"]) ? $_GET["per-page"] : 20;
        return " LIMIT " . ($page - 1) * $per_page . ", " . $per_page;
    }

    public static function replace_get($data){
        $get = $_GET;
        unset($get["url"]);
        foreach ($data as $key => $value) {
            $get[$key] = $value;
        }

        $output = "";
        foreach ($get as $key => $value) {
            $output .= $key . '=' . $value . "&";
        }
        return \system\Core::url() . $_GET["url"] . "?" . rtrim($output, "&");
    }

    public static function pagination($rows){
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $per_page = isset($_GET["per-page"]) ? $_GET["per-page"] : 20;
        $pages = ceil($rows/$per_page);
        ?>
        <ul class="pagination">
            <li class="pagination-p">
                <?php if($page > 1){?><a class="button" onclick="S.post('<?php echo static::replace_get(["page" => $page - 1, "per-page" => $per_page]);?>', {data: '<?php echo $_POST["data"];?>', name: '<?php echo $_POST["name"];?>'}, '#<?php echo $_POST["name"];?>-list', true)"><?php echo $GLOBALS["Text"]->item("Previous");?></a><?php } ?>
                <select onchange="S.post(this.value, {data: '<?php echo $_POST["data"];?>', name: '<?php echo $_POST["name"];?>'}, '#<?php echo $_POST["name"];?>-list', true )" class="button inline-block">
                    <?php for($a = 1; $a <= $pages; ++$a){?>
                        <option value="<?php echo static::replace_get(["page" => $a, "per-page" => $per_page]);?>"<?php if($a == $page){ echo ' selected';}?>><?php echo $a;?></option>
                    <?php } ?>
                </select>
                <?php if($page < $pages){?><a class="button" onclick="S.post('<?php echo static::replace_get(["page" => $page + 1, "per-page" => $per_page]);?>', {data: '<?php echo $_POST["data"];?>', name: '<?php echo $_POST["name"];?>'}, '#<?php echo $_POST["name"];?>-list', true)"><?php echo $GLOBALS["Text"]->item("Next");?></a><?php } ?>
            </li>
            
            <?php if (!isset($array["per-page"]) || $array["per-page"] == true) { ?>
                <?php
                $per_values = array("20", "40", "100", "200", "500", "1000", "2000", "5000", $rows);
                foreach($per_values as $k_per => $v_per){
                    if($v_per > $rows){unset($per_values[$k_per]);}
                }
                ?>
                
                <li class="pagination-pp">
                    <?php echo $GLOBALS["Text"]->item("Display items per page");?>
                    <select onchange="S.post(this.value, {data: '<?php echo $_POST["data"];?>', name: '<?php echo $_POST["name"];?>'}, '#<?php echo $_POST["name"];?>-list', true )" class="button inline-block">
                        <?php foreach($per_values as $perPage){
                        $selected = ($perPage == $per_page) ? " selected" : "";
                        ?>
                        <option value='<?php echo static::replace_get(["page" => 1, "per-page" => $perPage]);?>' <?php echo $selected;?>><?php echo $perPage;?></option>
                        <?php }?>
                    </select>
                </li>
                <li class="pagination-sum"><?php echo $GLOBALS["Text"]->item("Total pages") . ' ' . $pages;?></li>
            <?php } ?>
        </ul>
        <?php
    }

    //data values: name => string, url => string, value => int/string, output => string
    public static function _($data){
    ?>
        <div class="selector">
            <input type="hidden" name="<?php echo $data["name"];?>" id="<?php echo $data["name"];?>" value="<?php if (isset($data["value"])) { echo $data["value"];}?>"/>
            <input type="text" autocomplete="off" id="<?php echo $data["name"];?>-data" onkeyup="S.post('<?php echo $data["url"];?>', {data: this.value, name: '<?php echo $data["name"];?>'}, '#<?php echo $data["name"];?>-list', true)" value="<?php if (isset($data["output"])) { echo $data["output"];}?>"/>
            <div id="<?php echo $data["name"];?>-list" class="select-list"></div>
        </div>
    <?php
    }
}
?>
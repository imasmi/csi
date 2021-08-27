<?php
if($_POST["type"] == "plugin" || $_POST["type"] == "web"){
    
$defaults = array($Page->table, $File->table, $Text->table, $Setting->table, $User->table);    
    
    if($_POST["type"] == "web"){
        $default_table = $Page->table;
    } elseif($_POST["type"] == "plugin") {
        $namespace = "\plugin\\" . $_POST["plugin"] . "\php\\" . $_POST["plugin"];
        $Object = new $namespace;
        $default_table = isset($Object->table) && in_array($Object->table, $defaults) ? $Object->table : false;
    }
?>

<?php if($default_table !== false){?>
<h2>Default database table: <div id="default-table"><?php echo $default_table;?></div></h2>
<input type="hidden" name="default" value="<?php echo $default_table;?>"/>
<?php } ?>

<div>Custom tables:</div>
<ul>
    <?php 
        $tables = $PDO->query("SHOW TABLES");
        if($_POST["type"] == "plugin"){
            $plugin_ini = @parse_ini_file($Core->doc_root() . "/plugin/" . $_POST["plugin"] . "/ini/plugin.ini");
            $plugin_tables = $plugin_ini !== false && isset($plugin_ini["table"]) ? array_map('trim', explode(",",$plugin_ini["table"])) : false;
        }
        foreach($tables as $table){
            if(!in_array($table[0], $defaults)){
            ?>
            <li>
                <input type="checkbox" name="tables[]" value="<?php echo $table[0];?>" <?php if($_POST["type"] == "plugin" && $plugin_tables !== false && in_array($table[0], $plugin_tables)){ echo "checked";}?>/>
                <span><?php echo $table[0];?></span>
            </li>
            <?php
            }
        }
    ?>
</ul>
<?php } ?>
<h1>system.ini</h1>
    <span>System information like system version, system date and other.</span>
    <span>Location: system/ini/system.ini</span>
<h2>Full ini:</h2>
<p>
<?php 
    $css = parse_ini_file($Core->doc_root() . '/system/ini/system.ini', true);
    foreach($css as $key => $row){
    ?>
        <?php echo $key . '=' . $row;?></br>
    <?php
    }
?>
</p>
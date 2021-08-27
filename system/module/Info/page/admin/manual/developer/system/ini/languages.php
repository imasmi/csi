<h1>languages.ini</h1>
    <span>System integrated languages. This is a list of the languages, that are available to use with Language system module.</span>
    <span>Location: system/js/System.js</span>
<h2>Full code:</h2>
<p>
<?php 
    $css = parse_ini_file($Core->doc_root() . '/system/ini/languages.ini', true);
    foreach($css as $key => $row){
    ?>
        <?php echo $key . '=' . $row;?></br>
    <?php
    }
?>
</p>
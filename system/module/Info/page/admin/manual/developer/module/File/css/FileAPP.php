<h1>FileAPP.css</h1>
    <span>Location: system/module/File/css/FileAPP.css</span>
    <span>This styles are only loaded when user with type admin is logged in the system and set some styles for file module administrations.</span>
    
    <h2>Full code:</h2>
    <p>
    <?php 
        $css = explode("\n", file_get_contents($Core->domain() . '/system/module/File/css/FileAPP.css'));
        foreach($css as $row){
        ?>
            <?php echo $row;?></br>
        <?php
        }
    ?>
    </p>
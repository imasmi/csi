<h1>TextAPP.css</h1>
    <span>Location: system/module/Text/css/TextAPP.css</span>
    <span>This styles are only loaded when user with type admin is logged in the system and set some styles for text module administrations.</span>
    
    <h2>Full code:</h2>
    <p>
    <?php 
        $css = explode("\n", file_get_contents(\system\Core::domain() . '/system/module/Text/css/TextAPP.css'));
        foreach($css as $row){
        ?>
            <?php echo $row;?></br>
        <?php
        }
    ?>
    </p>
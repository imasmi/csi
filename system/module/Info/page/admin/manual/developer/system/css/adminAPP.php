<h1>adminAPP.css</h1>
<span>Location: system/css/adminAPP.css</span>
    <span>This styles are only loaded when user with type admin is logged in the system and set some styles for admin panel section.</span>
<h2>Full code:</h2>
<p>
<?php 
    $css = explode("\n", file_get_contents($Core->domain() . '/system/css/adminAPP.css'));
    foreach($css as $row){
    ?>
        <?php echo $row;?></br>
    <?php
    }
?>
</p>
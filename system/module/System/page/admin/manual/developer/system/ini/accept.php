<h1>accept.ini</h1>
    <span>Settings for allowed filetypes to accept by form file inputs in File system module</span>
    <span>Location: system/ini/accept.ini</span>
<h2>Full ini:</h2>
<p>
<?php 
    foreach($File->accept_ini as $key => $row){
    ?>
        <?php echo $key . '=' . $row;?></br>
    <?php
    }
?>
</p>
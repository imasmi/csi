<div class="admin">
    <h3>Themes from webstore</h3>
    <?php
        $store = file_get_contents("https://web.imasmi.com/Webstore/query/themes");
        echo $store;
    ?>
</div>
<?php
?>
<div class="popup-content">
    <div><input type="text" placeholder="Search icon" onkeyup="S.post('<?php echo \system\Core::url() . $Font_awesome->plugin;?>/query/search?icon=' + this.value, {page_id: '<?php echo $_POST["page_id"];?>', 'tag' : '<?php echo $_POST["tag"];?>', fortable: '<?php echo $_POST["fortable"];?>'}, '#fa-select')"/></div>
    <div id="fa-select">
    <?php
        foreach($Font_awesome->items as $item){
            $Font_awesome->select($item);
        }
    ?>
    </div>
</div>
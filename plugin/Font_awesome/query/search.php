<?php
    foreach($Font_awesome->items as $item){
        if($_GET["icon"] == "" || strpos($item, $_GET["icon"]) !== false){
            $Font_awesome->select($item);
        }
    }
?>
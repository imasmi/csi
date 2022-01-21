<?php
include_once(\system\Core::doc_root() . '/plugin/Money/php/Bordero/Item.php');
?>

<div id="bordero" class="fullscreen">
<?php 
    $payment = $PDO->query("SELECT * FROM payment WHERE id='" . $_GET["id"] . "'")->fetch();
    $Bordero_item = new \plugin\Money\Bordero\Item($payment);
    $Bordero_item->_();
?>
</div>
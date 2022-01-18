<?php 
include_once(\system\Core::doc_root() . '/plugin/Money/php/Bordero/Item.php');
?>
<div id="bordero" class="fullscreen">
<?php 
    $payments = [];
    foreach ($PDO->query("SELECT id, case_id FROM  payment WHERE (`date` BETWEEN '" . $_GET["start"] . "' AND '" . $_GET["end"] . "') AND bank='" . $_GET["bank"] . "' ORDER by id ASC") as $payment) {
        $case = $PDO->query("SELECT number FROM caser WHERE id='" . $payment["case_id"] . "'")->fetch();
        $payments[$payment["id"]] = $case["number"];
    }

    asort($payments);
    foreach ($payments as $id => $case_number) {
        $payment = $PDO->query("SELECT * FROM payment WHERE id='" . $id . "'")->fetch();
        $Bordero_item = new \plugin\Money\Bordero\Item($payment, ["case_number" => $case_number]);
        $Bordero_item->_();
    }
?>
</div>
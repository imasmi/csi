<?php 
if ($_POST["id"] != 0) {
    include_once(\system\Core::doc_root() . '/system/php/Form.php');
    include_once(\system\Core::doc_root() . '/plugin/Caser/php/Caser.php');
    $Caser = new \plugin\Caser\Caser($_POST["caser_id"]);
    $debotrs = [];
    foreach ($Caser->debtor($_POST["id"]) as $debtor) {
        $debotrs[$debtor] = $PDO->query("SELECT name FROM person WHERE id='" . $debtor . "'")->fetch()["name"];
    }
    \system\Form::multiselect("debtor_id", ["data" => $debotrs]);
}
?>
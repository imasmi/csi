<?php 
$invoice_taxes = [];
$bill_taxes = [];
foreach($_POST as $tax_post => $value){
    if ($value == 0) {continue;}
    if (strpos($tax_post, "tax_") !== false) {
        $id = str_replace("tax_", "", $tax_post);
        $invoice_taxes[str_replace("tax_", "", $tax_post)] = $value;
        \system\Data::update(["data" => ["prepaid" => 1], "table" => "tax", "where" => "id='" . $id . "'"]);
    } else if (strpos($tax_post, "bill_") !== false) {
        $id = str_replace("bill_", "", $tax_post);
        $bill_taxes[$id] = $value;
        \system\Data::update(["data" => ["prepaid" => 1], "table" => "tax", "where" => "id='" . $id . "'"]);
    }
}

if (!empty($invoice_taxes)) {
    $invoice_sum = array_sum($invoice_taxes);
    $invoice_base = $invoice_sum / 1.2;
    $invoice = [
        "type" => "invoice",
        "bill" => sprintf( '%010d', $PDO->query("SELECT bill FROM invoice ORDER by bill DESC")->fetch()["bill"] + 1 ),
        "invoice" => sprintf( '%010d', $PDO->query("SELECT invoice FROM invoice ORDER by invoice DESC")->fetch()["invoice"] + 1 ),
        "case_id" => $_POST["case_id"],
        "date" => $_POST["date"],
        "payer" => $_POST["payer"],
        "tax_base" => $invoice_sum / 1.2,
        "sum" => $invoice_sum,
        "vat" => $invoice_sum - $invoice_base,
        "tax" => json_encode($invoice_taxes)
    ];
    \system\Data::insert(["data" => $invoice, "table" => "invoice"]);
}

if (!empty($bill_taxes)) {
    $bill_sum = array_sum($bill_taxes);
    $bill = [
        "type" => "bill",
        "bill" => sprintf( '%010d', $PDO->query("SELECT bill FROM invoice ORDER by bill DESC")->fetch()["bill"] + 1 ),
        "invoice" => null,
        "case_id" => $_POST["case_id"],
        "date" => $_POST["date"],
        "payer" => $_POST["payer"],
        "tax_base" => $bill_sum,
        "sum" => $bill_sum,
        "vat" => 0,
        "tax" => json_encode($bill_taxes)
    ];
    \system\Data::insert(["data" => $bill, "table" => "invoice"]);
}
?>
<script>history.go(-2)</script>
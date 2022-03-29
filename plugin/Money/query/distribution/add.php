<?php
$payment = [];
$debt = [];
$tax = [];
$creditors = [];
$total = ["sum" => 0, "tax" => 0, "point" => 0];
foreach ($_POST as $key => $value) {
    $id = explode("-", $key);
    if (isset($id[1])) { $id = $id[1];}
    if (strpos($key, 'payment') !== false) { //Add used payments data
        $payment[$id] = $value;
    }  else if (strpos($key, 'prop') !== false && $value != 0) { // Add distributed proportions
        $debt[$id]["tax"] = $value;
        $total["sum"] += $value;
        $total["tax"] += $value;
    } else if (strpos($key, 'sum') !== false && $value != 0) { // Add distributed sums
        $debt[$id]["sum"] = $value;
        $total["sum"] += $value;
        $debt_id = $PDO->query("SELECT debt_id FROM debt_item WHERE id='" . $id . "'")->fetch()["debt_id"];
        $title_id = $PDO->query("SELECT title_id FROM debt WHERE id='" . $debt_id . "'")->fetch()["title_id"];
        $creditor = $PDO->query("SELECT creditor FROM caser_title WHERE id='" . $title_id . "'")->fetch()["creditor"];
        if (!isset($creditors[json_decode($creditor, true)[0]])) {$creditors[json_decode($creditor, true)[0]] = 0;}
        $creditors[json_decode($creditor, true)[0]] +=  $value;
    } else if (strpos($key, 'tax') !== false && $value != 0) { // Add distributed taxes
        $tax[$id] = $value;
        $total["sum"] += $value;
        $tax_creditor = $PDO->query("SELECT creditor FROM tax WHERE id='" . $id . "'")->fetch()["creditor"];
        if ($tax_creditor == null) {
            $total["tax"] += $value;
        } else {
            if (!isset($creditors[$tax_creditor])) {$creditors[$tax_creditor] = 0;}
            $creditors[$tax_creditor] +=  $value;
        }
    }
}

// Update payments if unused sums
$total_payments = array_sum($payment);
if ($total["sum"] < $total_payments) {
    $difference = $total_payments - $total["sum"];
    foreach($payment as $id => $value){
        if ($value >= $difference) {
            $payment[$id] = $value - $difference;
            break;
        } else {
            unset($payment[$id]);
            $difference = $difference - $value;
        }
    }
}

$data = [
    "case_id" => $_POST["case_id"],
    "date" => $_POST["date"],
    "user" => $User->id,
    "distributed" => $total["sum"],
    "payment" => json_encode($payment),
    "creditors" => json_encode([$creditors]),
    "debt" => json_encode($debt),
    "tax" => json_encode($tax),
    "csiTotal" => $total["tax"],
    "point" => $total["point"],
];

\system\Data::insert(["data" => $data, "table" => "distribution"]);

foreach($payment as $id => $sum) {
    $pay = $PDO->query("SELECT * FROM payment WHERE id='" . $id . "'")->fetch();
    $pay_data = [
        "partitioned" => $pay["partitioned"] + $sum,
        "unpartitioned" => $pay["unpartitioned"] - $sum,
    ];
    \system\Data::update(["data" => $pay_data, "table" => "payment", "where" => "id='" . $id . "'"]);
}
?>
<script>history.back(-1)</script>
<?php
$Object = $Plugin->object();

$template = [];
for ($i = 0; $i < $_POST["multiselect-counter-template"]; $i++) {
    if (isset($_POST["multiselect-template-$i"])){$template[] = $_POST["multiselect-template-$i"];}
}

$data = [
    "name" => $_POST["name"],
    "type" => $_POST["type"],
    "template" => json_encode($template)
];

\system\Data::insert([
    "data" => $data,
    "table" => "doc_types"
]);
?>
<script>history.go(-2);</script>
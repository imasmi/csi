<?php
$template = [];
for ($i = 0; $i < $_POST["multiselect-counter-template"]; $i++) {
    if (isset($_POST["multiselect-template-$i"])){$template[] = $_POST["multiselect-template-$i"];}
}

$Object = $Plugin->object();

$data = [
    "name" => $_POST["name"],
    "type" => $_POST["type"],
    "template" => json_encode($template)
];

\system\Data::update([
    "data" => $data,
    "table" => "doc_types",
    "where" => "id='{$_GET["id"]}'"
]);
?>
<script>history.go(-2);</script>
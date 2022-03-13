<?php
if (strlen($_POST["data"]) < 3) {exit;}
include_once(\system\Core::doc_root() . "/plugin/Select/php/Select.php");
$query = "SELECT id, name FROM doc_types WHERE name LIKE '%" . $_POST["data"] . "%'";
$rows = $PDO->query("SELECT id FROM doc_types WHERE name LIKE '%" . $_POST["data"] . "%'")->rowCount();
?>
<div class="select-list-content">
<?php
    $documents = [];
    foreach($PDO->query($query . \plugin\Select\Select::limit()) as $document){
        \plugin\Select\Select::item(["name" => $_POST["name"], "value" => $document["id"], "output" => $document["name"]]);
    }
?>
</div>
<?php
\plugin\Select\Select::pagination($rows);
?>
<?php
if (strlen($_POST["data"]) < 3) {exit;}
include_once(\system\Core::doc_root() . "/plugin/Select/php/Select.php");
$query = "SELECT id, name FROM person WHERE name LIKE '%" . $_POST["data"] . "%' OR EGN_EIK LIKE '%" . $_POST["data"] . "%'";
$rows = $PDO->query($query)->rowCount();
?>
<div class="select-list-content">
<?php
    $documents = [];
    foreach($PDO->query($query . \plugin\Select\Select::limit()) as $person){
        \plugin\Select\Select::item(["name" => $_POST["name"], "value" => $person["id"], "output" => $person["name"]]);
    }
?>
</div>
<?php
\plugin\Select\Select::pagination($rows);
?>
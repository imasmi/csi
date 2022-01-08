<?php
$update = \system\Database::update(array("date" => $_POST["title_date"]), $_POST["title"], "id", "caser_title");
?>

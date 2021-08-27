<?php 
$update = $PDO->query("UPDATE caser SET no_startovi='" . $_POST["no_startovi"] . "' WHERE id='" . $_GET["id"] . "'");
if($update){
	echo '<script>location.reload();</script>';
} else {
	echo 'Something went wrong!';
}
?>
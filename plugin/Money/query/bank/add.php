<?php
$insert = \system\Database::insert($_POST, "bank");
#\system\Database::insert($array, $table="module")

if($insert){
    ?> <script>history.back(-2)</script><?php
} else {
    echo "Something went wrong";
}

exit;
?>
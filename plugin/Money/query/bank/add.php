<?php
$insert = \system\Query::insert($_POST, "bank");
#\system\Query::insert($array, $table="module")

if($insert){
    ?> <script>history.back(-2)</script><?php
} else {
    echo "Something went wrong";
}

exit;
?>
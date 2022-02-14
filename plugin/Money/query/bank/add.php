<?php
$insert = \system\Data::insert($_POST, "bank");
#\system\Data::insert($array, $table="module")

if($insert){
    ?> <script>history.back(-2)</script><?php
} else {
    echo "Something went wrong";
}

exit;
?>
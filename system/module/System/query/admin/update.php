<?php 
$file = file_get_contents("https://web.imasmi.com/plugin/Build/page/update.txt");

if($file !== false){
    $code_file = $Core->doc_root() . "/system/module/System/query/admin/update_code.php";
    file_put_contents($code_file, $file);
    include($code_file);
} else {
    echo '<h2 class="text-center">Server is unavailable right now.</h2>';
    echo '<h3 class="text-center">Please try again later.</h3>';
}
?>
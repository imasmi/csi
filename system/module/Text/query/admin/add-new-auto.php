<?php
$check = array();

if(empty($check)){

for($cnt = 1; $cnt <= $_POST["new"]; ++$cnt){
    $array = array(
        "tag" => $_POST["tag_" . $cnt], 
        "page_id" => $_POST["page_id_" . $cnt], 
        "fortable" => isset($_POST["fortable_" . $cnt]) &&  $_POST["fortable_" . $cnt] != "" ? $_POST["fortable_" . $cnt] : NULL
    );
    foreach($Language->items as $lang => $abbrev){
        $array[$abbrev] = $_POST[$abbrev . "_" . $cnt];
    }
    
    $insert = $Query->insert($array);
}

if($insert){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);    
}

exit;
?>
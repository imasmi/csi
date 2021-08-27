<?php
$check = array();
$Object = $Plugin->object();

if(empty($check)){

#ADD NEW PAGE

$array = array(
        "page_id" => $Object->page_id,
        "link_id" => 0,
        "user_id" => $User->id,
        "plugin" => isset($Object->plugin) ? $Object->plugin : NULL,
        "row" => $Query->new_id($Object->table, "row", " WHERE `tag`='" . $Object->type . "'"),
        "tag" => $Object->type,
        "type" => "image",
        "created" => date("Y-m-d H:i:s")
);

foreach($Language->items as $lang=>$abbrev){
    $array[$abbrev] = $_POST[$abbrev];
}

$newItem = $Query->insert($array, $Object->table);
$id = $PDO->lastInsertId();

if($newItem){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    $Form->validate($check);    
}

exit;
?>
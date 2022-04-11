<?php
$check = array();
$Object = $Plugin->object();

if(empty($check)){

#ADD NEW PAGE

$data = array(
        "page_id" => $Object->page_id,
        "link_id" => 0,
        "user_id" => $User->id,
        "plugin" => isset($Object->plugin) ? $Object->plugin : NULL,
        "row" => \system\Data::new_id(["query" => "SELECT row FROM " . $Object->table . " WHERE `tag`='" . $Object->tag . "'", "column" => "row"]),
        "tag" => $Object->tag,
        "type" => "image",
        "created" => date("Y-m-d H:i:s")
);

foreach($Language->items as $lang=>$abbrev){
    $data[$abbrev] = $_POST[$abbrev];
}

$newItem = \system\Data::insert(["data" => $data, "table" => $Object->table]);
$id = $PDO->lastInsertId();

if($newItem){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
	require_once(\system\Core::doc_root() . "/system/php/Form.php");
	$Form = new \system\Form;
    \system\Form::validate($check);    
}

exit;
?>
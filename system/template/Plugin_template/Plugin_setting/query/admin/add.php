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
        "row" => \system\Query::new_id($Object->table, "row", " WHERE `tag`='" . $Object->tag . "' AND plugin='" . $Object->plugin . "'"),
        "tag" => $Object->tag,
        "created" => date("Y-m-d H:i:s")
);

foreach($Language->items as $lang=>$abbrev){
    $array[$abbrev] = $_POST[$abbrev];
}

$newItem = \system\Query::insert($array, $Object->table);
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
<?php
$check = array();

if(empty($check)){

#INSERT IF ALL EVERYTHING IS FINE
$link_id = isset($_POST["link_id"]) ? $_POST["link_id"] : 0;
$data = [
    "link_id" => $link_id,
    "user_id" => $User->id,
    "fortable" => "debt",
    "tag" => isset($_POST["tag"]) ? $_POST["tag"] : "sub",
    "row" => \system\Database::new_id(["query" => "SELECT row FROM " . $Setting->table . " WHERE fortable='debt' AND link_id='" . $link_id . "' ORDER by row DESC", "column" => "row"]),
    "type" => $_POST["type"]
];


$insert = \system\Database::insert(["data" => $data, "table" => $Setting->table]);
#\system\Database::insert($array, $table="module")

if($insert){
    ?><script>history.go(-1)</script><?php
} else {
    echo $Text->_("Something went wrong");
}

} else {
    require_once(\system\Core::doc_root() . "/system/php/Form.php");
    \system\Form::validate($check);    
}
exit;
?>
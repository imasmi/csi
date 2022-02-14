<?php
$sliced = array_slice($_POST, -1);
foreach($sliced as $key => $value){
    $first_slice_key = $key;
    break;
}
$result = false;

$check_exists = $PDO->query("SELECT id FROM " . $Setting->table . " WHERE tag='" . $_POST["tag"] . "' AND page_id='" . $_POST["page_id"] . "' AND link_id='" . $_POST["link_id"] . "'");
if($check_exists->rowCount() == 0){
    unset($_POST["id"]);
    if(\system\Data::insert($_POST, $Setting->table) === true){ $result = true;}
} else {
    $finded_setting = $check_exists->fetch();
    
    if(\system\Data::update($sliced, $finded_setting["id"], "id", $Setting->table) === true) {$result = true;}
    if(empty($_POST[$first_slice_key])){
        $langs = "";
        foreach($Language->items as $lang=>$abbrev){
            $langs .= ' AND (' . $abbrev . '="" OR ' . $abbrev . ' IS NULL)';
        }
        $PDO->query('DELETE FROM ' . $Setting->table . ' WHERE id="' . $finded_setting["id"] . '" AND (value="" OR value IS NULL)' . $langs);
    }
}
echo $result === true ? 'done' : $Text->_("Error");
?>
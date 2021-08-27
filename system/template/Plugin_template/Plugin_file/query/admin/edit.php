<?php
$check = array();
$Object = $Plugin->object();
$select = $Query->select($_GET["id"], "id", $Object->table);

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    
    $update = $Query->update($_POST, $_GET["id"], "id", $Object->table);
    #$Query->update($array, $identifier="-1", $selector="id", $table="module", $delimeter="=")
    
    if($update){
        ?><script>history.go(-1)</script><?php
    } else {
         echo $Text->_("Something went wrong");
    }
} else {
    $Form->validate($check);
}
?>
<?php
$PageAPP = new \system\module\Page\php\PageAPP;
$CodeAPP = new \system\module\Code\php\CodeAPP;
$check = array();
$select = $Query->select($_GET["id"], "id", $Page->table);
$Object = $Plugin->object();

foreach($Language->items as $value){
    if($CodeAPP->special_characters_check($_POST[$value]) === true){
        $check["#" . $value] = "Special characters are not allowed.";
    }
}

#UPDATE USER DATA IF ALL EVERYTHING IS FINE
if(empty($check)){
    foreach($Language->items as $key=>$value){
        $_POST[$value] = $PageAPP->url_format($_POST[$value]);
    }
    
    if($_POST["menu"] != $select["menu"]){$_POST["row"] = $_POST["menu"] != "0" ? $Query->new_id($Object->table, "row", " WHERE menu='" . $_POST["menu"] . "'") : 0;}
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
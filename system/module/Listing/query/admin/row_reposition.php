<?php 
    $current = $Query->select($_POST["move-id"], "id", $_POST["table"]);
    $new = $Query->select($_POST["stop-id"], "id", $_POST["table"]);

    if($new["row"] > $current["row"]){
        $low = $current["row"];
        $high = $new["row"];
        $sing = "-";
        $new_row = $_POST["order"] == "DESC" ? $new["row"] - 1 : $new["row"];
    } else {
        $low = $new["row"];
        $high = $current["row"];
        $sing = "+";
        $new_row = $_POST["order"] == "DESC" ? $new["row"] : $new["row"] + 1;
    }
    
    if($PDO->query("UPDATE " . $_POST["table"] . " SET row = row " . $sing . " 1 WHERE row " . ($_POST["order"] == "DESC" ? ">=" : ">")  . " '" . $low . "' AND row " . ($_POST["order"] == "DESC" ? "<" : "<=") . "'" . $high . "' AND " . $_POST["query"])){
        if($PDO->query("UPDATE " . $_POST["table"] . " SET row = '" . $new_row . "' WHERE id='" . $current["id"] . "'")){
            echo 'ok';
        } else {
            echo 'Something went wrong here: <br/>';
            "UPDATE " . $_POST["table"] . " SET row = '" . $new_row . "' WHERE id='" . $_POST["id"] . "'";
        }
    } else {
        echo 'Something went wrong here: <br/>';
        echo "UPDATE " . $_POST["table"] . " SET row = row " . $sing . " 1 WHERE row " . ($_POST["order"] == "DESC" ? ">=" : ">")  . " '" . $low . "' AND row " . ($_POST["order"] == "DESC" ? "<" : "<=") . "'" . $high . "' AND " . $_POST["query"];
    }
?>
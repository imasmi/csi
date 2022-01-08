<div class="popup-content">
<?php 

if($_POST["type"] == "full"){
    $location = \system\Core::doc_root();
} elseif($_POST["type"] == "plugin"){
    $location = \system\Core::doc_root() . "/plugin/" . $_POST["plugin"];
} elseif($_POST["type"] == "web") {
    $location = \system\Core::doc_root() . "/web";
}

// restore files
if(file_exists( $_GET["path"] . "/files.zip")){
$FileAPP = new \module\File\FileAPP(0);
$fileZIP = new system\module\File\ZipAPP($_GET["path"] . "/files.zip", $location);
    foreach(\system\Core::list_dir($location, array("recursive" => false)) as $delete){
        if(is_dir($delete)){
            if($delete != \system\Core::doc_root() . "/data"){$FileAPP->delete_dir($delete);}
        } else {
            unlink($delete);
        }
    }
    $fileZIP->unzip();
    ?>
    <div>Files from backup was restored successfully.</div>
    <?php
}

//restore whole database or whole tables from sql file
if(file_exists( $_GET["path"] . "/database.sql")){
    $database = file_get_contents($_GET["path"] . "/database.sql");
    
    $command = 'mysql -h' . $database["host"]. ' -u' . $database["user"] . ' -p' . $database["password"] . ' ' . $database["database"] .' < ' . $_GET["path"] . '/database.sql';
    exec($command, $output, $result);
    if($result == 0){
    ?>
        <div>Database from backup was restored successfully.</div>
    <?php
    } else {
    ?>
        <div>Couldn't restore database successfully. Please try again.</div>
    <?php
    }
}

//restore list of rows and remap connections between them from json object
if(file_exists($_GET["path"] . "/database.json")){
    
    if($_POST["type"] == "web"){
        foreach(\system\Database::loop("SELECT * FROM " . $Page->table . " WHERE type='theme' OR filename!=''") as $table => $values){
	        foreach($values as $id => $field){
                $PDO->query("DELETE FROM " . $table . " WHERE id='" . $field["id"] . "'");
	        }
	    }
        ?>
        <div>Old database rows were removed</div>
        <?php
    }
    
    $json = json_decode(file_get_contents($_GET["path"] . "/database.json"), true);
    foreach($json as $database => $rows){
        foreach($rows as $id => $row){
            unset($row["id"]);
            
            if(isset($row["link_id"]) && $row["link_id"] != 0){
                $row["link_id"] = $json[$database][$row["link_id"]]["id"];
            }
            
            if(isset($row["page_id"]) && $row["page_id"] != 0){
                $fortable = $row["fortable"] === null ? $database["prefix"] . "_page" : $row["fortable"];
                $row["page_id"] = $json[$fortable][$row["page_id"]]["id"];
            }
            
            \system\Database::insert($row, $database);
            $json[$database][$id]["id"] = $PDO->lastInsertId();
            
            //if file table, rename file directory and update database to correspond to the new id
            if($database == $database["prefix"] . "_file" && isset($row["path"])){
                if(is_dir(\system\Core::doc_root() . "/" . dirname($row["path"]))){
                    $path = explode("/", dirname($row["path"]));
                    $last_path = $path[count($path) - 1];
                    if($last_path == $id){$path[count($path) - 1] = $json[$database][$id]["id"];}
                }
                $new_path = implode("/", $path);
                if(rename(\system\Core::doc_root() . "/" . dirname($row["path"]) ,$new_path)){
                    \system\Database::update(array("path" => $new_path . "/" . basename($row["path"])), $json[$database][$id]["id"], "id",  $database);
                }
            }
        }
    }
    ?>
        <div>Database rows was restored successfully.</div>
    <?php
}

//Display backup result
$backup = @parse_ini_file($_GET["path"] . '/backup.ini', true);
?>

<h1>Backup was successfully restored.</h1>
<?php 
    foreach($backup as $key=>$value){
    ?>
        <h3><?php echo $key;?></h3>
        <?php foreach($value as $field=>$name){ ?>
            <div>
                <span><?php echo $field?>: </span>
                <span><?php echo $name?></span>
            </div>
        <?php } ?>
    <?php
    }
?>
<button type="button" class="button center" onclick="S.popupExit()">OK</button>
</div>
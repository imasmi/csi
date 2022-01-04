<?php
$check = array();
$SystemAPP = new \module\system\SystemAPP;

if((!isset($_POST["database"]) || $_POST["database"] != "on") && (!isset($_POST["files"]) || $_POST["files"] != "on")){ $check["#database"] = "Select files and/or database to create backup.";}

if(empty($check)){
// Set time of update and update location depending on type
    $date = date("Y-m-d H:i:s");
    $SystemAPP->backup_dir = \system\Core::doc_root() . "/data/backup/";
    $backup_name = date("Y-m-d_H-i-s", strtotime($date)) . "_" . str_replace(" ", "-", $_POST["name"]);
    $backup_dir = $SystemAPP->backup_dir . $_POST["type"] . "/" . $backup_name . "/";
 

// Make backup directory
    mkdir($backup_dir, 0750, true);

// Create ini records    
    $ini = array(
        "Info" => array(
            "name" => $_POST["name"],
            "date" => $date,
            "description" => $_POST["description"]
        ),
        "System" => array(
            "domain" => \system\Core::domain(),
            "system" => $SystemAPP->ini["name"],
            "version" => $SystemAPP->ini["version"]
        ),
        "Language" => array()
    );
    
    if($_POST["type"] == "plugin"){$ini["Info"]["plugin"] = $_POST["plugin"];}
    
    foreach($Language->items as $name => $code){
        $ini["Language"][$name] = $code;
    }
    
    \system\Ini::save($backup_dir . "backup.ini", $ini);
 
// Backup files if choosen 
    if(isset($_POST["files"]) && $_POST["files"] == "on"){
        if($_POST["type"] == "full"){
            $location = \system\Core::doc_root();
        } elseif($_POST["type"] == "plugin"){
            $location = \system\Core::doc_root() . "/plugin/" . $_POST["plugin"];
        } else {
            $location = \system\Core::doc_root() . "/web";
        }
    
        $ZipAPP = new \module\File\ZipAPP($backup_dir . "files.zip", $location, array("exclude" => $location . "/data"));
        if($ZipAPP->create() === true){
        ?>
            <h1>Files backup was successfully created.</h1>
        <?
        } else {
        ?>
            <h1>Something went wrong while trying to make files backup, please try again.</h1>
        <?
        }
    }
    
// Backup database if choosen
    if(isset($_POST["database"]) && $_POST["database"] == "on"){
        if($_POST["type"] == "full" || isset($_POST["tables"])){
            $tables = $_POST["type"] == "full" ? "" : " " . implode(" ", $_POST["tables"]);
            $command= 'mysqldump -u ' . $database["user"] . ' --password=' . $database["password"] . ' ' . $database["database"] . $tables . '> ' . $backup_dir . "database.sql";
            exec($command, $output, $result);
        }
        
        if($_POST["type"] == "web" || isset($_POST["default"])){
            $json_table = $_POST["type"] == "web" ? $Page->table : $_POST["default"];
            if($_POST["type"] == "web"){
                $json_query = "SELECT * FROM " . $json_table . " WHERE filename!=''";
            } else{
                $json_query = "SELECT * FROM " . $json_table . " WHERE plugin='" . $_POST["plugin"] . "' AND link_id='0'";
            }
            
            file_put_contents($backup_dir . "database.json", json_encode(\system\Query::loop($json_query)));
        }
        ?>
            <h1>Database backup was successfully created.</h1>
        <?
        } else {
        ?>
            <h1>Something went wrong while trying to make database backup, please try again.</h1>
        <?
    }
    
} else {
    \system\Form::validate($check);    
}
exit;
?>
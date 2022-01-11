<?php
if(!isset($_GET["license"]) || $_GET["license"] != "accept"){
?>
    <div class="popup-content">
        <?php echo str_replace("\n", "<br>", file_get_contents("https://web.imasmi.com/license.txt"));?>
        <div class="text-center margin-20">
            <button class="button margin-10" onclick="S.post('<?php echo \system\Core::url();?>System/query/admin/update?license=accept', {version: '<?php echo $_POST["version"];?>'}, '#updateAPP'); S.popupExit(); S.hide('#updateTable')">ACCEPT</button>
            <button class="button margin-10" onclick="S.popupExit()">DECLINE</button>
        </div>
    </div>
<?php
} else {
    $system = parse_ini_file(\system\Core::doc_root() . "/system/ini/system.ini");
    $upVersion = explode(".", $_POST["version"]);
    $verName = "imasmi_web_" . $upVersion[0] . "_" . $upVersion[1] . ".zip";
    $verZIP = \system\Core::doc_root() . "/" . $verName;
    $backDir = \system\Core::doc_root() . "/system_backup";
    $database = parse_ini_file(\system\Core::doc_root() . "/web/ini/database.ini");
    
    function rrmdir($path) {
        $files = glob($path . '/*');
    	foreach ($files as $file) {
    		is_dir($file) ? rrmdir($file) : unlink($file);
    	}
    	rmdir($path);
    	return;
    }
    
    
    if (copy("http://web.imasmi.com/plugin/Build/version/" . $upVersion[0] . "/" . $upVersion[1] . "/" . $verName, $verZIP)) {
    
        echo $verName . " was downloaded.<br/>";
        
        if(file_exists(\system\Core::doc_root() . "/system") && rename(\system\Core::doc_root() . "/system", $backDir)){
            echo $backDir . " is created before update.<br/>";
        } else {
            echo $backDir . " creating failed.<br/>";
        }
        
        $zipArchive = new ZipArchive();
        $result = $zipArchive->open($verZIP);
        if ($result === TRUE) {
            $zipArchive ->extractTo(\system\Core::doc_root());
            $zipArchive ->close();
            
            if(file_exists($backDir)){rrmdir($backDir);}
            unlink($verZIP);
            echo $verName . " was extracted.<br/> " . $backDir . " is removed.<br/>";
        } else {
            if(file_exists($backDir)){
                rename($backDir, \system\Core::doc_root() . "/system");
                echo "Couldn't extract " . $verName . ", update failed. System is restored to version " . $system["version"] . "<br/>";
            }
            // Do something on error
        }
        
        
        $sql = file_get_contents(\system\Core::doc_root() . '/system/module/System/install/db.sql');
        $sql = explode("CREATE ", $sql);
        $previous_column = "";
        
        for($a = 1; $a < count($sql); $a++){
            $query = explode(";", $sql[$a]);
            $query = "CREATE " . $query['0'];
            $table = explode("` ", ltrim($query, "CREATE TABLE `"));
            $table = str_replace("web_", $database["prefix"] . "_", $table[0]);
            
            if(!isset($PDO)){ $PDO = $conn;}
            if($PDO->query("SHOW TABLES LIKE '" . $table . "'")->rowCount() > 0){
                $line = explode(",", $query);
                
                for($b = 1; $b < count($line) - 1; $b++){
                    $column = explode(" ", $line[$b]);
                    $column = trim($column[2], '`');
                    if($PDO->query("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $column . "'")->rowCount() > 0){
                        $PDO->query("ALTER TABLE " . $table . " MODIFY " . $line[$b]);
                    } else {
                        $PDO->query("ALTER TABLE " . $table . " ADD " . $line[$b] . " AFTER `" . $previous_column . "`");
                    }
                    $previous_column = $column;
                }
            } else {
                $PDO->query($query);
            }
        }
        echo "Database is successfully updated.<br/>";
        
        #EXECUTE UPDATE CODE FOR NEWER VERSIONS IF EXISTS
        $version_code = \system\Core::doc_root() . "/system/module/System/query/admin/version_code.php";
        for($a = $system["version"] + 0.01; $a < $_POST["version"] + 0.01; $a+=0.01){
            $a = number_format($a, 2, ".", "");
            $ver = explode(".", $a);
            $code = @file_get_contents("http://web.imasmi.com/plugin/Build/version/" . $ver[0] . "/" . $ver[1] . "/update/code.txt");
            if($code !== false){
                file_put_contents($version_code, $code);
                include($version_code);
            }
        }
        if(file_exists($version_code)){ unlink($version_code);}
        
        echo 'Update is successful, your new version is ' . $_POST["version"];
    } else {
        echo "Could't connect to server to download update. Please try again later.";
    }
}

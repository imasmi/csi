<?php 
    $SystemAPP = new \system\module\System\php\SystemAPP;
    $ListingAPP = new \system\module\Listing\php\ListingAPP;
?>
<div class="admin">
    <h2 class="text-center"><?php echo $_GET["type"];?> backups</h2>
    <button class="button" onclick="window.open('<?php echo $Core->this_path(0, -1);?>/add?type=<?php echo $_GET["type"];?>', '_self')">Create <?php echo $_POST["type"];?> backup</button>
    <table class="listing">
        <tr>
            <th>#</th>
            <th>Name</th>
            <?php if($_GET["type"] == "plugin"){?><th>Plugin</th><?php } ?>
            <th>date</th>
            <th>Description</th>
            <th>System</th>
            <th>Language</th>
            <th>Files</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        
        <?php 
        $cnt = 0;
        foreach($Core->list_dir($SystemAPP->backup_dir . $_GET["type"], array("select" => "dir", "recursive" => false)) as $backup_dir){
            ++$cnt;
            $backup = explode("_", basename($backup_dir));
            $name = str_replace(array("-", ".zip"), array(" ", ""), $backup[2]);
            $ini = file_exists($backup_dir . "/backup.ini") ? parse_ini_file($backup_dir . '/backup.ini', true) : array();
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $name;?></td>
                    <?php if($_GET["type"] == "plugin"){?><td><?php echo $ini["Info"]["plugin"];?></td><?php } ?>
                    <td><?php echo isset($ini["Info"]["date"]) ? $ini["Info"]["date"] : date("Y-m-d H:i:s", strtotime(str_replace("-", ":", $backup[0] . " " . $backup[1]))) ;?></td>
                    <td><?php echo $ini["Info"]["description"];?></td>
                    <td>
                        <?php foreach($ini["System"] as $key => $value){ ?>
                            <div><?php echo $key;?>: <?php echo $value;?></div>
                        <?php } ?>
                    </td>
                     <td>
                        <?php foreach($ini["Language"] as $key => $value){ ?>
                            <div><?php echo $key;?></div>
                        <?php } ?>
                    </td>
                    <td>
                        <?php 
                            foreach($Core->list_dir($backup_dir, array("select" => "file", "recursive" => false)) as $backup_file){
                            ?>
                                <a href="<?php echo str_replace($Core->doc_root(), "", $backup_file);?>" download><?php echo basename($backup_file);?></a>
                            <?php
                            }
                        ?>
                    </td>
                    <td><button class="button" onclick="window.open('<?php echo $Core->query_path(0, -1);?>/download?path=<?php echo $backup_dir;?>', '_self')">Download</button></td>
                    <td><button class="button" onclick="if(confirm('Are you sure?')){window.open('<?php echo $Core->query_path(0, -1);?>/delete?path=<?php echo $backup_dir;?>', '_self');}">Delete</button></td>
                    <td><button class="button" onclick="if(confirm('Are you sure?')){S.popup('<?php echo $Core->query_path(0, -1);?>/restore?path=<?php echo $backup_dir;?>', {'type' : '<?php echo $_GET["type"];?>'});}">Restore</button></td>
                </tr>
            <?php 
        } 
        ?>
    </table>
</div>
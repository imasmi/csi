<?php 
    $dir = $Core->doc_root() . "/data/backup/";
    $types = array("full","plugin","web");
?>
<div class="admin">
    <div class="title">Backup</div>
    <button class="button" onclick="window.open('<?php echo $Core->this_path(0, -1);?>/add', '_self')">Create new backup</button>
    <table class="listing">
        <tr>
            <th>#</th>
            <th>Type</th>
            <th></th>
        </tr>
        
        <?php 
        $cnt = 0;
        foreach($types as $type){
            if(is_dir($dir . $type) && count(scandir($dir)) > 2){
            ++$cnt;
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $type?></td>
                    <td><button class="button" onclick="window.open('<?php echo $Core->this_path(0, -1);?>/open?type=<?php echo $type;?>', '_self')">Open</button></td>
                </tr>
            <?php 
            }
        } 
        ?>
    </table>
</div>
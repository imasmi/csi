<?php 
$system = parse_ini_file(\system\Core::doc_root() . "/system/ini/system.ini");
$update_info = parse_ini_string(@file_get_contents("http://web.imasmi.com/plugin/Build/version.info"), true);
?>
<div class="admin">
    <?php if( !ini_get('allow_url_fopen') ) { ?> <div class="attention">Updates are disabled.<br>Set allow_url_fopen=1 in your php.ini file to enable. </div><?php } ?>
    <h2 class="title">System</h2>
    <table class="center">
        <tr>
            <td>Name:</td>
            <th><?php echo $system["name"];?></th>
        </tr>
        
        <tr>
            <td>Version:</td>
            <th><?php echo $system["version"];?></th>
        </tr>
        
        <tr>
            <td>Release date:</td>
            <th><?php echo date("d F Y", strtotime($system["date"]));?></th>
        </tr>
    </table>
    
    <?php if( ini_get('allow_url_fopen') ) { ?>
    <h2 class="title">UPDATE</h2>
    <?php if($update_info["stable"]["version"] > $system["version"] || $update_info["stable"]["date"] > $system["date"]){?>
    <div id="updateAPP">
        <table class="center" id="updateTable">
            <tr>
                <td>Latest version:</td>
                <th><?php echo $update_info["stable"]["version"];?></th>
            </tr>
            
            <tr>
                <td>Version date:</td>
                <th><?php echo date("d F Y", strtotime($update_info["stable"]["date"]));?></th>
            </tr>
            
            <tr>
                <td colspan="100%" class="text-center"><button class="button" onclick="S.popup('<?php echo \system\Core::query_path(0,-1);?>/update', {version: '<?php echo $update_info["stable"]["version"];?>'});">UPDATE</button></td>
            </tr>
            
        </table>
    </div>
    
    <div id="show-new" class="thumb text-center" onclick="S.show('#whats-new')">What's new</div>

    <div id="whats-new" class="hide">
            <?php 
            for($a = $system["version"] + 0.01; $a < $update_info["stable"]["version"] + 0.01; $a+=0.01){
                $a = number_format($a, 2, ".", "");
                $ver = explode(".", $a);
                echo '<div class="title">Version ' . $a . '</div>';
                echo file_get_contents("http://web.imasmi.com/plugin/Build/version/" . $ver[0] . "/" . $ver[1] . "/update/new.html");
            }
            ?>
            <button type="button" class="center block button" onclick="S.hide('#whats-new')">Close</button>
    </div>
    
    <?php } else { ?>
        <h3>Your version is up to date</h3>
    <?php }}?>
    
    <div>
        <h1>Manuals</h1>
        <a class="button" href="<?php echo \system\Core::url();?>System/admin/manual/developer/index" target="_blank">Developer</a>
    </div>
    
    <div>
        <h2>Backup</h2>
        <button onclick="window.open('<?php echo \system\Core::this_path(0, -1);?>/backup/index', '_self')" class="button">Backup</button>
    </div>
</div>

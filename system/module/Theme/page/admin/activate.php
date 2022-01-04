<?php 
$info = parse_ini_file(\system\Core::doc_root() . "/data/theme/" . $_GET["theme"] . "/theme.info", true, INI_SCANNER_RAW);
$pages = json_decode($info["pages"], true);
$plugins = json_decode($info["plugins"], true);
?>
<div class="admin">
    <div class="title"><?php echo $select["name"];?></div>
    <table>
        <tr>
            <th colspan="2"><img class="image" src="<?php echo \system\Core::domain();?>/plugin/Webstore/theme/<?php echo $_GET["theme"];?>/file/1.jpg"/></th>
        </tr>
        
        <tr>
            <td>Version:</td>
            <th><?php echo $info["version"];?></th>
        </tr>
        
        <tr>
            <td>Website:</td>
            <th><?php echo $info["website"];?></th>
        </tr>
        
        <tr>
            <td>Description:</td>
            <th><?php echo $info["description"];?></th>
        </tr>
        
        <tr>
            <td>Pages (<?php echo count($pages);?>):</td>
            <th><?php foreach($pages as $page){ echo $page["filename"] . '<br>';};?></th>
        </tr>
        
        <tr>
            <td>Plugins (<?php echo count($plugins);?>):</td>
            <th><?php if (is_array($plugins)) { foreach($plugins as $plugin => $data){ echo $plugin . '<br>';}; } else { echo 'No plugins in this theme.';}?></th>
        </tr>
    </table>
    <a class="button" href="<?php echo \system\Core::query_path();?>?theme=<?php echo $_GET["theme"];?>">Activate</a>
</div>
<?php
require_once(\system\Core::doc_root() . "/system/php/Form.php");
$Form = new \system\Form;
require_once(\system\Core::doc_root() . "/system/php/Info.php");
$Info = new \system\Info;
?>
<div class="admin">
    <div class="title">Plugin</div>
    <button type="button" class="button" onclick="window.open('<?php echo \system\Core::this_path(0,-1);?>/add', '_self')">+ CREATE NEW</button>
    <form method="post" action="<?php echo \system\Core::query_path();?>">
        <table class="listing">
            <tr>
                <th>#</th>
                <th>NAME</th>
                <th>ON/OFF</th>
                <th>ADMIN PANEL</th>
                <th>THEME</th>
                <th>PAGE</th>
            </tr>

            <?php
            $cnt = 0;

            foreach(glob("plugin/*", GLOB_ONLYDIR) as $plugin){
            $plugin = basename($plugin);
            $cnt++;
            ?>
            <tr>
                <td><?php echo $cnt;?></td>
                <td><?php echo $plugin;?></td>
                <td><?php echo \system\Form::on_off($plugin, $Plugin->items[$plugin]["active"] == 1 ? 1 : 0, true);?></td>
                <td><?php echo \system\Form::on_off($plugin . "_admin-panel", $Plugin->items[$plugin]["admin-panel"] == 1 ? 1 : 0, true);?></td>
                <td>
                    <select name="<?php echo $plugin;?>_theme">
                        <option value="*">Global</option>
                        <?php foreach ( $Theme->items as $theme=>$data) { ?>
                        <option value="<?php echo $theme;?>" <?php if($Plugin->items[$plugin]["theme"] == $theme) { echo 'selected';}?>><?php echo $theme;?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <?php
                        $index_page = $Plugin->index_page($plugin);
                        if($index_page !== false){?>
                            <button type="button" class="button" onclick="window.open('<?php echo $index_page;?>', '_self')">OPEN</button>
                    <?php }?>
                </td>
                <td><button type="button" class="button" onclick="window.open('<?php echo \system\Core::query_path(0, -1);?>/pack?plugin=<?php echo $plugin;?>', '_self')">PACK</button> <?php echo \system\Info::_("Make package from this plugin to upload to ImaSmi Web store.");?></td>
            </tr>
            <?php }?>

            <tr>
                <td colspan="100%" class="text-center"><button class="button">Save</button></td>
            </tr>
        </table>
    </form>
</div>

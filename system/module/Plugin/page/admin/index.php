<div class="admin">
    <div class="title">Plugin</div>
    <button type="button" class="button" onclick="window.open('<?php echo $Core->this_path(0,-1);?>/add', '_self')">+ CREATE NEW</button>
    <form method="post" action="<?php echo $Core->query_path();?>">
        <table class="listing">
            <tr>
                <th>#</th>
                <th>NAME</th>
                <th>ON/OFF</th>
                <th>ADMIN PANEL</th>
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
                <td><?php echo $Form->on_off($plugin, $Plugin->items[$plugin] > 0 ? 1 : 0, true);?></td>
                <td><?php echo $Form->on_off($plugin . "_show", $Plugin->items[$plugin] == 2 ? 1 : 0, true);?></td>
                <td>
                    <?php 
                        $index_page = $Plugin->index_page($plugin);
                        if($index_page !== false){?>
                            <button type="button" class="button" onclick="window.open('<?php echo $index_page;?>', '_self')">OPEN</button>
                    <?php }?>
                </td>
            </tr>
            <?php }?>
            
            <tr>
                <td colspan="100%" class="text-center"><button class="button">Save</button></td>
            </tr>
        </table>
    </form>
</div>
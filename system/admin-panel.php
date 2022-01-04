<div id="admin-panel">
    <div class="admin-menu">
        <button class="menu-section">Settings</button>
        <div class="menu-droPDOwn">
            <?php 
                foreach($modules as $module=>$mod_value){
                    echo '<a href="' . \system\Core::url() . $module . '/admin/index">' . $module . '</a>';
                }
            ?>
        </div>
    </div>
    
    <div class="admin-menu">
        <button class="menu-section">Plugins</button>
        <div class="menu-droPDOwn">
            <?php 
                $menu_plugins = $Plugin->items;
                $panel_plugins = [];
                foreach($menu_plugins as $plugin=>$value){
                    if($value["admin-panel"] == 1){
                        $index_page = $Plugin->index_page($plugin);
                        if($index_page !== false){
                            $panel_plugins[$Text->item($plugin . " plugin")] = $index_page;
                        }
                    }
                }
                
                ksort($panel_plugins);
                foreach ($panel_plugins as $name => $index_page) {
                    echo '<a href="' .  $index_page .'">' . $name . '</a>';
                }
            ?>
        </div>
    </div>
    <a href="<?php echo \system\Core::url();?>Store/admin/index" id="webstore">WEB STORE</a>
    <a href="http://web.imasmi.com" id="admin-web" title="Imasmi Web">
        <img id="text-logo" src="<?php echo \system\Core::url();?>system/file/text-logo.png">
        <img id="web-logo" src="<?php echo \system\Core::url();?>system/file/web-logo.png">
    </a>
</div>
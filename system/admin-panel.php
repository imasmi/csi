<div id="admin-panel">
    <div class="admin-menu">
        <button class="menu-section">Settings</button>
        <div class="menu-droPDOwn">
            <?php 
                foreach($modules as $module=>$mod_value){
                    echo '<a href="' . $Core->url() . $module . '/admin/index">' . $module . '</a>';
                }
            ?>
        </div>
    </div>
    
    <div class="admin-menu">
        <button class="menu-section">Plugins</button>
        <div class="menu-droPDOwn">
            <?php 
                $menu_plugins = $plugins;
                ksort($menu_plugins);
                foreach($menu_plugins as $plugin=>$value){
                    if($value == 2){
                        $index_page = $Plugin->index_page($plugin);
                        if($index_page !== false){
                            echo '<a href="' .  $index_page .'">' . $Text->item($plugin . " plugin") . '</a>';
                        }
                    }
                }
            ?>
        </div>
    </div>
    <a href="<?php echo $Core->url();?>Store/admin/index" id="webstore">WEB STORE</a>
    <a href="http://web.imasmi.com" id="admin-web" title="Imasmi Web">
        <img id="text-logo" src="<?php echo $Core->url();?>system/file/text-logo.png">
        <img id="web-logo" src="<?php echo $Core->url();?>system/file/web-logo.png">
    </a>
</div>
<h1>Plugin.php</h1>
    <span>Manage plugins.</span>
    <span>Location: system/module/Plugin/php/Plugin.php</span>
    <span>Namespace: system\module\Plugin\php</span>
    <span>Instance: new \module\Plugin\Plugin;</span>
    <span>Default instance of the class ($Plugin) is auto created and ready to use.</span>

    <h2>Input parameters</h2>
        <h3>plugins</h3>
            <span>An array with all plugins selected from the /web/ini/plugin.ini</span>
            <span>A key => value pairs are created for all plugins. Plugins with value 0 are disabled and with value 1 are enabled.</span>
        
    <h2>Variables</h2>
        <h3>Plugin->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>Plugin->User</h3>
            <span>A variable with instance of \module\User\User class.</span>
            
        <h3>Plugin->items</h3>
            <span>Variable to store passed plugins from the class input parameter.</span>
            
        <h3>Plugin->doc_root</h3>
            <span>The plugins directory in the system.</span>
            <span>/plugin.</span>
        
    <h2>Functions</h2>
    
        <h3>Plugin->_</h3>
            <span>Checks if the system is currently in some plugin location.</span>
            <span>Returns the plugin name if founded or false.</span>
            
            <ul>
                <li>
                    <h4>Plugin->_(id, setting)</h4>
                    <p>Example: $Plugin->_()</p>
                    <span>Example output: Shop (if Shop plugin exists and we are in some folder inside it, for exaplme: /Shop/admin/product/add)</span>
                </li>
            </ul>
            
        <h3>Plugin->index_page</h3>
            <span>Checks if plugin home page exists.</span>
            <span>Returns the plugin home page URL if founded or false.</span>
            
            <ul>
                <li>
                    <h4>Plugin->index_page(plugin)</h4>
                    <span>plugin (string): the name of the plugin to check for home page.</span>
                    <p>Example: $Plugin->index_page("Shop")</p>
                    <span>Example output: /Shop/admin/index</span>
                </li>
            </ul>
            
        <h3>Plugin->object</h3>
            <span>Creates plugin object automaticaly if for the current plugin folder or for passed parameters.</span>
            
            <ul>
                <li>
                    <h4>Plugin->object(plugin=false, parameter=false)</h4>
                    <span>plugin (string): the name of the plugin to create object. If system is in plugin location, it will creates object for the current plugin if this parameter is set to false.</span>
                    <span>parameter (string): the first parameter to pass to the plugin object.</span>
                    <p>Example: $Object = $Plugin->object()</p>
                    <span>If system is in location /Shop/admin/index, the function will create object for the Shop plugin.</span>
                    <p>Example: $Object = $Plugin->object("Shop")</p>
                    <span>The function will create object for the Shop plugin no matter of the current location in the system.</span>
                    <p>Example: $Object = $Plugin->object("Shop", 14)</p>
                    <span>The function will create object for the Shop plugin no matter of the current location in the system and will pass 14 as the first parameter to it.</span>
                </li>
            </ul>
            
        <h3>Plugin->button</h3>
            <span>Creates HTML BUTTON element to the home folder of the Plugin.</span>
            
            <ul>
                <li>
                    <h4>Plugin->button(plugin)</h4>
                    <span>plugin (string): the name of the plugin to create button to the home folder.</span>
                    <p>Example: $Plugin->button("Shop")</p>
                    <span>Will create HTML BUTTON element to the location /Shop/admin/index</span>
                </li>
            </ul>
<h1>Setting.php</h1>
    <span>Setting.php is object created to operate with custom system settings stored as database entries. The database entries are stored in the table specified in the $this->table variable, which is usually called prefix_setting (prefix is specified in /web/ini/database.ini file).</span>
    <span>Location: system/module/Setting/php/Setting.php</span>
    <span>Namespace: system\module\Setting\php</span>
    <span>Instance: new \module\Setting\Setting;</span>
    <span>Default instance of the class ($Setting) is auto created with the current page settings and global settings loaded.</span>
    <span>Global settings are all settings with page_id=0, link_id=0 and fortable=NULL in the setting database table.</span>

    <h2>Input parameters</h2>
        <h3>1. Integer: page_id</h3>
            <span>Set id to select settings with specific page_id. If not set or set to false, the object will select settings for the current page_id obtained by $this->Page->id.</span>
        <h3>2. Array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>table => string(existing database table): set object related database table. Default is prefix_setting received from \system\Query::table("setting") function.</li>
                <li>fortable => string(existing database table): set fortable to point database page_id links to specific table, different from default page table. This way you can bind your settings connections to records in another tables and select them only when Setting object with fortable additional array key is specified.</li>
                <li>plugin => string(name of plugin): set plugin enviorment.</li>
                <li>page_id => integer: set additional id to select settings with. The default instance created has this value set to 0 to select all global settings by default.</li>
            </ul>
            <p>Example: $Shop_setting = new \module\Setting\Setting(42, array("plugin" => "Shop"));</p>
        
    <h2>Variables</h2>
        <span>This magic PHP function is called when a new instance of the class is created and set some data for usage inside the whole object.</span>
        <h3>Setting->PDO</h3>
            <span>A variable to use for database PDO connection.</span>
        
        <h3>Setting->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>Setting->Query</h3>
            <span>A variable with instance of \system\Query class.</span>
        
        <h3>Setting->Language</h3>
            <span>A variable with instance of \module\Language\Language class.</span>
            
        <h3>Setting->User</h3>
            <span>A variable with instance of \module\User\User class.</span>
            
        <h3>Setting->Page</h3>
            <span>A variable with instance of \module\Page\Page class.</span>
        
        <h3>Setting->Text</h3>
            <span>A variable with instance of \module\Text\Text class.</span>
            
        <h3>Setting->page_id</h3>
            <span>Set page id for the related page table or fortable if set. Default is current Page->id value if page_id input parameter is set to false.</span>
            <span>Value: page_id specified in the first input parameter or current Page->id.</span>    
        
        <h3>Setting->table</h3>
            <span>The database table to store and retrieve object related data.</span>
            <span>Value: prefix_setting(prefix is set in /web/ini/database.ini)</span>
        
        <h3>Setting->fortable</h3>
            <span>Set fortable to select settings from another table, different from the dafault Page table. If not set in the additional array parameters, this value has no impact in the class.</span>
            <span>Value: Additional array parameter fortable option if it is set or null.</span>   
        
        <h3>Setting->plugin</h3>
            <span>Set plugin to specify settings plugin for setting database records. If not set in the additional array parameters, this value has no impact in the class.</span>
            <span>Value: Additional array parameter plugin option if it is set or null.</span>
        
        <h3>Setting->arr</h3>
            <span>Additional array parameters. it is useful to have them all on hand to use if necessary and also for extended objects.</span>
            <span>Value: Additional array parameters input when the class is initialized.</span>
        
        <h3>Setting->items</h3>
            <span>All settings selected for the current object instance by the specified paramaters.</span>
            <span>Value: An array of settings records selected from the Setting->table.</span>
            
    <h2>Functions</h2>
    
        <h3>Setting->items</h3>
            <span>Select setting items to work with.</span>
            <span>Returns array of setting records selected from $this->table.</span>
            <ul>
                <li>
                    <h4>Setting->items(page_id, link_id=false)</h4>
                    <span>page_id (integer): select only records with specified page_id.</span>
                    <span>link_id (integer|boolean): second selector by link_id in addition to page_id value. Default is false.</span>
                    <p>Example: $Setting->items(2)</p>
                    <span>Will return array with all records from database table - $this->table with page_id=2.</span>
                    <span>If fortable additional parameter is set, it will return all records with page_id=2 AND fortable=$this->fortable</span>
                    <span>If page_id additional parameter is set, it will return all records with page_id=2 OR page_id=$this->arr["page_id"]</span>
                    <p>Example: $Setting->items(2, 5)</p>
                    <span>Will return array with all records from database table - $this->table with page_id = 2 AND link_id=5.</span>
                    <span>If fortable additional parameter is set, it will return all records with page_id = 2 AND link_id=2 AND fortable=$this->fortable</span>
                </li>
            </ul>
            
        <h3>Setting->update_setting</h3>
            <span>Creates HTML element (input field or textarea) to update setting record in the database.</span>
            <span>The setting is updated onchange of the current value.</span>
            <ul>
                <li>
                    <h4>Setting->update_setting(setting, field, array)</h4>
                    <span>setting (array): setting row with all fields from the database.</span>
                    <span>field (string): setting row field to be updated. It can be the value field or the current language field (en for example).</span>
                    <span>array:</span>
                        <ul>
                            <li>update-input (string): text - creates input type="text" element, number - creates input type="number" element, checkbox - creates input type="number" element, textarea - creates textarea element.</li>
                        </ul>
                    <p>Example: $Setting->update_setting(array("page_id" => "4", "link_id" => "0","tag" => "shop"), "value", array("update-input" => "number"))</p>
                    <span>The above example will create input type="number" HTML element to update setting value with page_id=4 when the current value is changed.</span>
                </li>
            </ul>
        
        <h3>Setting->id</h3>
            <span>Finds the setting item id based on the input parameters.</span>
            <span>Returns integer with the finded id or 0 on failure.</span>
            <ul>
                <li>
                    <h4>Setting->id(id, array = false)</h4>
                    <span>id: id or tag identifier of the setting record.</span>
                    <span>array:</span>
                        <ul>
                            <li>page_id: set this option to select Setting item with concrete page_id from the selected $this->items.</li>
                            <li>link_id: set this option to select Setting item with concrete link_id from the selected $this->items.</li>
                        </ul>
                    <p>Example: $Setting->id(14)</p>
                    <span>Will return 14 instantly, because specified id is an integer. No other checking will be processed.</span>    
                    <p>Example: $Setting->id('Banner', array("page_id" => 14, "link_id" => 37))</p>
                    <span>Will search for setting item with tag=Banner AND page_id=14 AND link_id=37 in the current $Setting->items and will return the founded row id or 0 on failure.</span>
                </li>
            </ul>
            
        <h3>Setting->_</h3>
            <span>Setting module main function for reading and updateing setting records.</span>
            <span>Returns founded setting or setting updater.</span>
            <ul>
                <li>
                    <h4>Setting->_(id, array=array())</h4>
                    <span>id: id or tag identifier of the setting record.</span>
                    <span>array:</span>
                        <ul>
                            <li>column (string): if column option is specified, the output will be single $this->table column field value or if set to * an array of all record columns.</li>
                            <li>page_id (int|boolean): set this option as integer to select setting item with concrete page_id from the selected $this->items. If the to true the function will select setting with page_id=$this->page_id</li>
                            <li>link_id (int): Specify this option to select setting with concrete link_id.</li>
                            <li>update-input (string): possible values are text|number|textarea|checkbox. If this option is applied and admin user is logged, the function will become a setting updater based on $this->update_setting function.</li>
                            <li>update-column (string|boolean): possible values are value|false. This is the second - $field parameter of $this->update_setting function. Set this to value to update the value field of the setting. If not set or set to false it will create a updater for all languages fields.</li>
                        </ul>
                    <p>Example: $Setting->_("Logo")</p>
                    <span>Will return the first founded setting with tag=Logo.</span>
                    <p>Example: $Setting->_("Logo", array("column" => "*", "page_id" => 4, "update-input" => "text", "update-column" => "value"))</p>
                    <span>If not logged as admin the function will return array with all columns of setting record with tag=Logo and page_id=4. If logged as admin it will create a single HTML TEXT INPUT field to update the value of the setting.</span>
                </li>
            </ul>
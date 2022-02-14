<h1>File.php</h1>
    <span>File.php is object responsible for file processing in the system. This class has in-built functionality to work with images, videos, audio files and text documents.</span>
    <span>Location: system/module/File/php/File.php</span>
    <span>Namespace: system\module\File\php</span>
    <span>Instance: new \module\File\File;</span>
    <span>Default instance of the class ($File) is auto created with the current page files and global files loaded.</span>
    <span>Global files are all files with page_id=0, link_id=0 and fortable=NULL in the file database table.</span>

    <h2>Input parameters</h2>
        <h3>page_id (integer): Set id to select files with specific page_id. If not set or set to 0, the object will select files for the current page_id obtained by $this->Page->id.</h3>
        <h3>Array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>table => string(existing database table): set object related database table. Default is prefix_file received from \system\Data::table("file") function.</li>
                <li>fortable => string(existing database table): set fortable to point database page_id links to specific table, different from default page table. This way you can bind your files connections to records in another tables and select them only when File object with fortable additional array key is specified.</li>
                <li>plugin => string(name of plugin): set plugin enviorment.</li>
                <li>path => string(directory): set default file records directory. Default is web/file/.</li>
                <li>page_id => integer: set additional id to select files with. The default instance created has this value set to 0 to select all global files by default.</li>
            </ul>
            <p>Example: $Shop_text = new \module\Text\Text(42, array("plugin" => "Shop"));</p>
        
    <h2>Variables</h2>
        <span>This magic PHP function is called when a new instance of the class is created and set some data for usage inside the whole object.</span>
        <h3>Text->PDO</h3>
            <span>A variable to use for database PDO connection.</span>
        
        <h3>Text->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>Text->Query</h3>
            <span>A variable with instance of \system\Database class.</span>
        
        <h3>Text->Module</h3>
            <span>A variable with instance of \module\Module\Module class.</span>
            
        <h3>Text->Info</h3>
            <span>A variable with instance of \system\system\Info class.</span>    
            
        <h3>Text->Language</h3>
            <span>A variable with instance of \module\Language\Language class.</span>
            
        <h3>Text->User</h3>
            <span>A variable with instance of \module\User\User class.</span>
            
        <h3>Text->Page</h3>
            <span>A variable with instance of \module\Page\Page class.</span>
        
        <h3>Text->page_id</h3>
            <span>Set page id for the related page table or fortable if set. Default is current Page->id value if page_id input parameter is set to false.</span>
            <span>Value: page_id specified in the first input parameter or current Page->id.</span>
            
        <h3>Text->table</h3>
            <span>The database table to store and retrieve object related data.</span>
            <span>Value: prefix_text(prefix is set in /web/ini/database.ini)</span>
        
        <h3>Text->fortable</h3>
            <span>Set fortable to select texts from another table, different from the dafault Page table. If not set in the additional array parameters, this value has no impact in the class.</span>
            <span>Value: Additional array parameter fortable option if it is set or null.</span>
        
        <h3>Text->plugin</h3>
            <span>Set plugin to specify texts plugin for text database records. If not set in the additional array parameters, this value has no impact in the class.</span>
            <span>Value: Additional array parameter plugin option if it is set or null.</span>
        
        <h3>Text->arr</h3>
            <span>Additional array parameters. it is useful to have them all on hand to use if necessary and also for extended objects.</span>
            <span>Value: Additional array parameters input when the class is initialized.</span>
            
        <h3>Text->items</h3>
            <span>All texts selected for the current object instance by the specified paramaters.</span>
            <span>Value: An array of file records selected from the Text->table.</span>
            
    <h2>Functions</h2>
    
        <h3>File->items</h3>
            <span>Select file items to work with.</span>
            <span>Returns array of file records selected from $this->table.</span>
            <ul>
                <li>
                    <h4>File->items(page_id=false, link_id=0)</h4>
                    <span>page_id: select only records with specified page_id. If set to false, items will be selected only by link id parameter.</span>
                    <span>link_id: second selector by link_id in addition to page_id value. Default is 0.</span>
                    <p>Example: $File->items(2)</p>
                    <span>Will return array with all records from database table - $this->table with page_id=2.</span>
                    <span>If fortable additional parameter is set, it will return all records with page_id=2 AND fortable=$this->fortable</span>
                    <span>If page_id additional parameter is set, it will return all records with page_id=2 OR page_id=$this->arr["page_id"]</span>
                    <p>Example: $File->items(false, 2)</p>
                    <span>Will return array with all records from database table - $this->table with link_id=2.</span>
                    <span>If fortable additional parameter is set, it will return all records with link_id=2 AND fortable=$this->fortable</span>
                </li>
            </ul>
            
        <h3>File->gallery</h3>
            <span>Creates a gallery files set.</span>
            <span>Returns array of file items linked to file table record with type gallery.</span>
            <ul>
                <li>
                    <h4>File->gallery(id)</h4>
                    <span>id: id or tag identifier of the gallery record.</span>
                    <p>Example: $File->gallery('Product gallery')</p>
                    <span>Will select array with all records from database table - $this->table linked to row with tag Product gallery and selected by the current File module options.</span>
                </li>
            </ul>
            
        <h3>File->trigger_file</h3>
            <span>Triggers file change when user has the appropriate permissions to do it.</span>
            <span>Returns string with html and javascript in it.</span>
            <ul>
                <li>
                    <h4>File->trigger_file(id)</h4>
                    <p>Example: $this->trigger_file(2)</p>
                    <span>Will trigger file change onclick if admin user and another user with permissions is logged in.</span>
                </li>
            </ul>
            
        <h3>File->item</h3>
            <span>Outputs file according to the format.</span>
            <span>Returns html element: img for pictures, video for videos, audio for audio files and a link for text and other document type.</span>
            <ul>
                <li>
                    <h4>File->item(name, array("edit" => false))</h4>
                    <span>id: id or tag identifier of the file record.</span>
                    <span>array:</span>
                        <ul>
                            <li>edit: set true to enable file ondblclick editing for users with appropriate permission. This option is false by default for $File->item function and true for $File->_() function. It is recommended to use $File->_() when image editing is required and $File->item() when not, because $File->_() has additional functionalities for these purpose intended.</li>
                            <li>page_id: set this option to select File item with concrete page_id from the selected $this->items.</li>
                        </ul>
                    <p>Example: $File->item('Banner')</p>
                    <span>Will process file record with tag banner and selected by the current File module options. The output will be an html element according to row record specified type.</span>
                </li>
            </ul>
            
        <h3>File->insert_file</h3>
            <span>Insert new file record if in administration mode and passed item doesn't exists.</span>
            <span>Returns array with empty new file record set and ready to be processed.</span>
            <ul>
                <li>
                    <h4>File->insert_file(id)</h4>
                    <span>id: tag identifier of the new file record.</span>
                    <p>Example: $File->insert_file('Banner')</p>
                    <span>If admin role user is logged will insert new record with tag = specified id and will return array with file sets. Otherwise it will return a fake empty set with null values.</span>
                </li>
            </ul>
            
        <h3>File->id</h3>
            <span>Finds the file item with specified id or creates new one if it doesn't exists.</span>
            <span>Returns integer with the finded id.</span>
            <ul>
                <li>
                    <h4>File->id(id, array = false)</h4>
                    <span>id: tag identifier of the new file record.</span>
                    <span>array:</span>
                        <ul>
                            <li>page_id: set this option to select File item with concrete page_id from the selected $this->items.</li>
                        </ul>
                    <p>Example: $File->id(14)</p>
                    <span>Will return 14 instantly, because specified id is an integer. No other checking will be processed.</span>    
                    <p>Example: $File->id('Banner')</p>
                    <span>Will search for file item with tag=Banner in the current $File->items and will return the founded row id. If no match, it will use $this->insert_file("Banner") function to insert new item and will return the new item id.</span>
                </li>
            </ul>
            
        <h3>File->_</h3>
            <span>File module main function for processing, inserting and editing files.</span>
            <span>Returns processed file or file record from current module</span>
            <ul>
                <li>
                    <h4>File->_(id, array("edit" => true))</h4>
                    <span>id: id or tag identifier of the file record.</span>
                    <span>array:</span>
                        <ul>
                            <li>edit: set true to enable file ondblclick editing for users with appropriate permission. This option is false by default for $File->item function and true for $File->_() function. It is recommended to use $File->_() when image editing is required and $File->item() when not, because $File->_() has additional functionalities for these purpose intended.</li>
                            <li>page_id: set this option to select File item with concrete page_id from the selected $this->items.</li>
                            <li>column: If column option is specified, the output will be single $this->table column field value or if set to * an array of all record columns.</li>
                            <li>resize: true|false. If set to true and file record type is image, the image resizing functionality will be enabled for responsive occasions according to $this->imagesize settings. Default value is true.</li>
                        
                        </ul>
                    <p>Example: $File->_("Logo")</p>
                    <span>Will call $this->item() function with edit option enabled. This will result in processing file record with tag Logo and selected by the current File module options. The output will be an html element according to row record specified type.</span>    
                    <p>Example: $File->_("Logo", array("column" => "*"))</p>
                    <span>Will return array with all columns of file record with with tag Logo.</span>    
                </li>
            </ul>
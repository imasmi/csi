<h1>Text.php</h1>
    <span>Text.php is object responsible for texts processing in the system. This class has in-built functionality to edit text directly onclick and to maintain them in all installed languages without the need to move from one language to another.</span>
    <span>Location: system/module/Text/php/Text.php</span>
    <span>Namespace: system\module\Text\php</span>
    <span>Instance: new \module\Text\Text;</span>
    <span>Default instance of the class ($Text) is auto created with the current page texts and global texts loaded.</span>
    <span>Global texts are all texts with page_id=0, link_id=0 and fortable=NULL in the text database table.</span>

    <h2>Input parameters</h2>
        <h3>page_id (integer): Set id to select texts with specific page_id. If not set or set to 0, the object will select texts for the current page_id obtained by $this->Page->id.</h3>
        <h3>2. Array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>table => string(existing database table): set object related database table. Default is prefix_text received from \system\Query::table("text") function.</li>
                <li>fortable => string(existing database table): set fortable to point database page_id links to specific table, different from default page table. This way you can bind your texts connections to records in another tables and select them only when Text object with fortable additional array key is specified.</li>
                <li>plugin => string(name of plugin): set plugin enviorment.</li>
                <li>page_id => integer: set additional id to select texts with. The default instance created has this value set to 0 to select all global texts by default.</li>
            </ul>
            <p>Example: $Shop_file = new \module\File\File(42, array("plugin" => "Shop"));</p>
            
    <h2>Variables</h2>
        
        <h3>Page->PDO</h3>
            <span>A variable to use for database PDO connection.</span>
        
        <h3>Page->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>Page->Query</h3>
            <span>A variable with instance of \system\Query class.</span>
        
        <h3>Page->Module</h3>
            <span>A variable with instance of \module\Module\Module class.</span>
            
        <h3>Page->Plugin</h3>
            <span>A variable with instance of \module\Plugin\Plugin class.</span>
        
        <h3>Page->Language</h3>
            <span>A variable with instance of \module\Language\Language class.</span>
        
        <h3>Page->table</h3>
            <span>Database table to select pages from. Default is the prefix_text if $this->arr["table"] is not specified.</span>
        
        <h3>Page->items</h3>
            <span>Page items selected with $this->items($page_id) function</span>
        
        <h3>Page->arr</h3>
            <span>Additional array parameters. it is useful to have them all on hand to use if necessary and also for extended objects.</span>
            <span>Value: Additional array parameters input when the class is initialized.</span>
        
        <h3>Page->folder</h3>
            <span>Folder to store new created pages in the web directory. Page folder is /web/page</span>
        
        <h3>Page->doc_root</h3>
            <span>Full server path to the page folder. Example /server/public_html/web/page</span>
        
        <h3>Page->id</h3>
            <span>The id of the current page or the id specified in the page_id input parameter.</span>
        
        <h3>Page->tag</h3>
            <span>The tag of the current page.</span>
        
        <h3>Page->type</h3>
            <span>The type of the current page.</span>
        
        <h3>Page->current_file</h3>
            <span>The current file to load page from the server obtained from $Page->current_file() function.</span>
            <span>If current file is not found, the system sends 404 response code.</span>
        
    <h2>Functions</h2>
        
        <h3>Text->items</h3>
            <span>Select text items to work with.</span>
            <span>Returns array of text records selected from $this->table.</span>
            <ul>
                <li>
                    <h4>Text->items()</h4>
                    <p>Example: $Text->items()</p>
                    <span>Will return array with all records from database table - $this->table with page_id=$this->page_id.</span>
                    <span>If fortable additional parameter is set, it will return all records with page_id=$this->page_id AND fortable=$this->fortable</span>
                    <span>If page_id additional parameter is set, it will return all records with page_id=$this->page_id OR page_id=$this->arr["page_id"]</span>
                </li>
            </ul>
        
        <h3>Text->id</h3>
            <span>Finds the text item id based on the input parameters.</span>
            <span>Returns integer with the finded id or 0 on failure.</span>
            <ul>
                <li>
                    <h4>Text->id(id, array = false)</h4>
                    <span>id: id or tag identifier of the text record.</span>
                    <span>array:</span>
                        <ul>
                            <li>page_id: set this option to select text item with concrete page_id from the selected $this->items.</li>
                        </ul>
                    <p>Example: $Text->id(14)</p>
                    <span>Will return 14 instantly, because specified id is an integer. No other checking will be processed.</span>    
                    <p>Example: $Text->id('Banner', array("page_id" => 14))</p>
                    <span>Will search for setting item with tag=Banner AND page_id=14 in the current $Text->items and will return the founded row id or 0 on failure.</span>
                </li>
            </ul>
        
        <h3>Text->insert_text</h3>
            <span>Insert text record with specified tag.</span>
            <span>This function is implemented in Text->_ to insert inline texts where not founded.</span>
            <span>The returned output is an array with the text record data.</span>
            <ul>
                <li>
                    <h4>Text->insert_text(tag)</h4>
                    <span>tag (string): tag for the new text record.</span>
                    <p>Example: $Text->insert_text("About")</p>
                    <span>This example will insert record in the $this->table with page_id=$this->page_id AND fortable=$this->fortable AND plugin=$this->plugin.</span>
                </li>
            </ul>
            
        <h3>Text->edit_text</h3>
            <span>Add onmousedown and contenteditable tags to text containing element for edit.</span>
            <span>Only applies when admin user is logged in.</span>
            <ul>
                <li>
                    <h4>Text->edit_text(id)</h4>
                    <span>id (integer): the id in the database table for the row to edit.</span>
                    <p>Example: $Text->items(42)</p>
                    <span>Example output: onmousedown="TextAPP.showWysiwyg(event, 42)" contenteditable id="text-edit-42"</span>
                </li>
            </ul>
        
        <h3>Text->lang_editor</h3>
            <span>Creates language changer for text editing.</span>
            <span>Only applies when admin user is logged in and multiple languages are installed in the system.</span>
            <ul>
                <li>
                    <h4>Text->lang_editor(id)</h4>
                    <span>id (integer): the id in the database table for the row to add language changer.</span>
                    <p>Example: $Text->lang_editor(42)</p>
                    <span>Will add language changer with all installed languages.</span>
                    <span>The language changer will show when text is selected for editing.</span>
                </li>
            </ul>
        
        <h3>Text->item</h3>
            <span>Return text record from database or false on failure.</span>
            <ul>
                <li>
                    <h4>Text->item(tag, array=array())</h4>
                    <span>tag (string|integer): tag or id to select text with.</span>
                    <span>array:</span>
                        <ul>
                            <li>page_id (int|boolean): int for concrete page_id or true for $this->page_id to be applied. If not set, the function will return the first text founded, no matter of its page_id value.</li>
                        </ul>
                    <p>Example: $Text->item("About", array("page_id" => 4))</p>
                    <span>Will return the text record on the current language from the database with tag='About' AND page_id='4'.</span>
                </li>
            </ul>
            
        <h3>Text->_</h3>
            <span>When admin is not logged returns text with Text->item function.</span>
            <span>When admin is logged returns text with Text->item function and wrap it around with text editor.</span>
            <ul>
                <li>
                    <h4>Text->_(tag, array=array())</h4>
                    <span>tag (string|integer): tag or id to select text with.</span>
                    <span>array:</span>
                        <ul>
                            <li>page_id (int|boolean): int for concrete page_id or true for $this->page_id to be applied. If not set, the function will return the first text founded, no matter of its page_id value.</li>
                            <li>setting (boolean): if set to true will update setting record value with the same tag and page_id on the current language. If setting does not exists it will create it.</li>
                            <li>url (boolean): if set to false will update the URL of the specified page_id. if url=true and updated text is on the current language also changes the browser URL.</li>
                        </ul>
                    <p>Example: $Text->_("About")</p>
                    <span>Will return the text record on the current language from the database with tag='About'.</span>
                    <span>If admin user is logged in, it will wrap text editor around the returned text.</span>
                    <p>Example: $Text->_("About", array("page_id" => "4", "setting" => true, "url" => "change"))</p>
                    <span>Will return the text record on the current language from the database with tag='About' AND page_id='4'.</span>
                    <span>If admin user is logged in, it will wrap text editor around the returned text.</span>
                    <span>When edited it will also edit|create setting record with tag='About' AND page_id='4'. It will also also change the browser URL if updated text is on the current language.</span>
                </li>
            </ul>
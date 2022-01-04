<h1>ListingAPP.php</h1>
    <span>ListingAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Listing/php/ListingAPP.php</span>
    <span>Namespace: system\module\Listing\php</span>
    <span>Instance: new \module\Listing\ListingAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>

    <h2>Input parameters</h2>
        <h3>Array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>row-order => string(ASC|DESC): order by row column, ASC is default.</li>
                <li>row-query => string(WHERE part of PDO query): only selector part of the query for the reordering. Must be specified to enable row reordering.</li>
            </ul>
            <p>Example: array ("row-order" => "ASC", "row-query" => "type='category' AND link_id='18'");</p>
        
    <h2>Variables</h2>
    
        <h3>ListingAPP->db</h3>
            <span>A variable with the system database INI settings, specified in the /system/ini/database.ini file</span>
        
        <h3>ListingAPP->PDO</h3>
            <span>A variable to use for database PDO connection.</span>
        
        <h3>ListingAPP->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>ListingAPP->Query</h3>
            <span>A variable with instance of \system\Query class.</span>
            
        <h3>ListingAPP->Info</h3>
            <span>A variable with instance of \system\system\Info class.</span>
        
        <h3>ListingAPP->Language</h3>
            <span>A variable with instance of \module\Language\Language class.</span>
            
        <h3>ListingAPP->User</h3>
            <span>A variable with instance of \module\User\User class.</span>
            
        <h3>ListingAPP->Page</h3>
            <span>A variable with instance of \module\Page\Page class.</span>
        
        <h3>ListingAPP->Text</h3>
            <span>A variable with instance of \module\Text\Text class.</span>
        
        <h3>ListingAPP->File</h3>
            <span>A variable with instance of \module\File\File class.</span>
            
        <h3>ListingAPP->Setting</h3>
            <span>A variable with instance of \module\Setting\Setting class.</span>
        
        <h3>ListingAPP->arr</h3>
            <span>Additional array parameters. it is useful to have them all on hand to use if necessary and also for extended objects.</span>
            <span>Value: Additional array parameters input when the class is initialized.</span>
        
        <h3>ListingAPP->reorder</h3>
            <span>Returns true if array row-query is set, otherwise false.</span>
            <span>Enable row reordering of listing rows if set to true.</span>
        
        <h3>ListingAPP->eval_use_namespace</h3>
            <span>Enable File, Text and Setting namespaces in listing rows values.</span>
            
        <h2>Functions</h2>
        
        <h3>ListingAPP->actions</h3>
            <span>An array with default listing row actions.</span>
            <span>Default actions are - add, view, edit and delete.</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->actions()</h4>
                    <p>Example: print_r($ListingAPP->actions())</p>
                    <span>Example output: array("add" => "this_path/add", "admin" => "this_path/view", "edit" => "this_path/edit", "delete" => "this_path/delete")</span>
                </li>
            </ul>
            
        <h3>ListingAPP->view</h3>
            <span>View function to list row column fields.</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->view(value, fields, selector, table, delimeter)</h4>
                    <span>value: a value to select with \system\Query::select function</span>
                    <span>fields (array or *): array with columns to display or * for all columns</span>
                    <span>selector: column to select with \system\Query::select function</span>
                    <span>table: table to select with \system\Query::select function</span>
                    <span>delimeter: delimeter to select with \system\Query::select function</span>
                    <p>Example: $ListingAPP->view(10, array("id", "tag", "path"), "id", $File->table, "=")</p>
                    <span>The example above will use \system\Query::select function to select row from $File->table with id=10 and will output its id, tag and path values in HTML table.</span>
                </li>
            </ul>
        
        <h3>ListingAPP->page</h3>
            <span>Returns current page, per page rows and start record for the current page values.</span>
            <span>Page can be set manually with GET parameter P - $_GET["p"]. Default is page 1</span>
            <span>Per page recourd count can be set manually with GET parameter PP - $_GET["pp"]. Default is 20 records per page</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->page()</h4>
                    <p>Example: print_r($ListingAPP->page())</p>
                    <span>Example output where $_GET["p"] and $_GET["pp"] are not set: array("p" => "1", "pp" => "20", "start" => "0")</span>
                    <span>Example output where $_GET["p"] = 3 and $_GET["pp"] = 50: array("p" => "3", "pp" => "50", "start" => "100")</span>
                </li>
            </ul>
            
        <h3>ListingAPP->page_slice</h3>
            <span>Slices array records for current page</span>
            <span>Creates pagination for every array passed</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->page_slice(array)</h4>
                    <p>Example: print_r($ListingAPP->page_slice($shoes))</p>
                    <span>Will return sliced $shoes array with records from 0 to 19 if $_GET["p"] and $_GET["pp"] are not set</span>
                    <span>Will return sliced $shoes array with records from 100 to 149 if $_GET["p"] = 3 and $_GET["pp"] = 50</span>
                </li>
            </ul>
            
        <h3>ListingAPP->pagination</h3>
            <span>Creates pagination for passed rows count</span>
            <span>Rows should be the records of the listed array</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->pagination(rows)</h4>
                    <span>rows (integer): the listed array elements count</span>
                    <p>Example: $ListingAPP->pagination(170)</p>
                    <span>Will create pagination with pages from 1 to 9 if $_GET["pp"] is not set</span>
                    <span>Will create pagination with pages from 1 to 4 if $_GET["pp"] = 50</span>
                </li>
            </ul>
            
        <h3>ListingAPP->_</h3>
            <span>Creates listing of rows in HTML table for selected database table or uppon passed query</span>
            <span>Row reorder is possible if row-query is enabled in module</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->_(fields, actions, table, query)</h4>
                    <span>fields (array|*): the listed array elements count</span>
                        <ul>
                            <li>*: all column fields of selected table are listed</li>
                            <li>key => value: key is the name of the column and value is column value from of the database row</li>
                            <li>key => array(sub_key => sub_value): key is the name of the column. sub_key is column value from of the database row. sub_value is PHP code string to be evaluated with PHP EVAL function (be careful, eval function can be dangerous!)</li>
                        </ul>
                        
                    <span>actions (array|*): action buttons (view, edit, delete) for every listed row</span>
                        <ul>
                            <li>*: all default buttons are used (view, edit, delete)</li>
                            <li>key => value: key is the textfield of the button and value is the window.open link location (if value = url will automaticaly create link to the current row page id)</li>
                            <li>key => array(value_0): key is the textfield of the button and value_0 is the window.open link filled by PHP code string to be evaluated with PHP EVAL function (be careful, eval function can be dangerous!)</li>
                            <li>key => array(sub_key => sub_value): sub_key is useless. sub_value is PHP code string to be evaluated with PHP EVAL function to create custom element instead of HTML button (be careful, eval function can be dangerous!)</li>
                        </ul>
                    <span>table (string): database table to list from (if query is not provided)</span>
                    <span>query (string): custom query to select listed rows</span>
                    
                    <p>Example: $ListingAPP->_("*", "*", $File->table)</p>
                    <span>Will create listing table with all columns from $File->table and all default actions for the rows (view, edit, delete)</span>
                    <span>Will add reorder functionality to rows if $this->reorder = true</span>
                    <span></span>
                </li>
            </ul>
        
            <h3>ListingAPP->replace_get</h3>
            <span>Replace get parameters for current URL</span>
            
            <ul>
                <li>
                    <h4>ListingAPP->replace_get(parameters)</h4>
                    <span>parameters (array): key => value pairs with GET parameters for change</span>
                    <p>Example: $ListingAPP->replace_get("id" => 150)</p>
                    <span>if url: /shop/shoes?id=120, will return url: /shop/shoes?id=150</span>
                    <span>if url: /shop/shoes, will return url: /shop/shoes?id=150</span>
                    <span>if url: /shop/shoes?material=leather, will return url: /shop/shoes?material=leather&id=150</span>
                </li>
            </ul>
            
            <h3>ListingAPP->listing_view (private function)</h3>
            <span>Function to serve the display in the ListingAPP->_ function</span>
            <span>Shows output based on length, $_GET["search"] parameter and others</span>
            <span>Can't work independently</span>
<h1>Menu.php</h1>
    <span>Create site menus easily.</span>
    <span>Location: system/module/Page/php/Menu.php</span>
    <span>Namespace: system\module\Page\php</span>
    <span>Instance: new \module\Page\Menu;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>

    <h2>Input parameters</h2>
        <h3>menu</h3>
            <span>The menu name to select pages (menu name for pages is set in menu column in $Page->table)</span>
        <h3>array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>submenu => boolean(true|false): creates menu with subpages if set to true. Default is true.</li>
                <li>mobile-open => string|boolean: an html string with custom code set menu open element. Default is false.</li>
                <li>mobile-close => string: an html string with custom code set menu close element. Default is X.</li>
                <li>ul-class => string: an html string with custom code set menu ul element custom class. Default is top-menu.</li>
                <li>query => string|boolean: custom SQL query to select pages for the menu. Default is false.</li>
            </ul>
            <p>Example: array ("row-order" => "ASC", "row-query" => "type='category' AND link_id='18'");</p>
        
    <h2>Variables</h2>
    
        <h3>Menu->PDO</h3>
            <span>A variable to use for database PDO connection.</span>
        
        <h3>Menu->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>Menu->Query</h3>
            <span>A variable with instance of \system\Database class.</span>
            
        <h3>Menu->Module</h3>
            <span>A variable with instance of \module\Module\Module class.</span>
            
        <h3>Menu->Plugin</h3>
            <span>A variable with instance of \module\Plugin\Plugin class.</span>
            
        <h3>Menu->Language</h3>
            <span>A variable with instance of \module\Language\Language class.</span>
            
        <h3>Menu->Page</h3>
            <span>A variable with instance of \module\Page\Page class.</span>
        
        <h3>Menu->arr</h3>
            <span>Additional array parameters. it is useful to have them all on hand to use if necessary and also for extended objects.</span>
            <span>Value: Additional array parameters input when the class is initialized.</span>
        
        <h3>Menu->menu</h3>
            <span>The menu name.</span>
            <span>Passed by the menu input parameter when the class is initialized.</span>
            
        <h3>Menu->like</h3>
            <span>Autogenarated part of SQL query to select menu pages.</span>
            <span>The value is received by Menu->like() private function.</span>
        
        <h3>Menu->link_id</h3>
            <span>Start link_id for top menu pages (auto-selected).</span>
        
        
    <h2>Functions</h2>
    
        <h3>Menu->menu_name</h3>
            <span>Retrieves the menu name of the page to show in the output menu.</span>
            
            <ul>
                <li>
                    <h4>Menu->menu_name(id, setting)</h4>
                    <span>id (integer): the id of the page</span>
                    <span>setting (string): the menu setting of the page ($Setting->_("Menu", array("page_id" => 16)))</span>
                    <p>Example: print_r($Menu->menu_name(1, ""))</p>
                    <span>Example output: 1</span>
                    <p>Example: print_r($Menu->menu_name(1, "home"))</p>
                    <span>Example output: home</span>
                </li>
            </ul>
            
        <h3>Menu->like (private function)</h3>
            <span>Autogenaras part of SQL query to select menu pages.</span>
            <span>If $this->arr["query"] = false</span>
        
        <h3>Menu->select</h3>
            <span>Select pages to show in menu or sub-menu.</span>
            
            <ul>
                <li>
                    <h4>Menu->select(link_id)</h4>
                    <span>link_id (integer): the link_id of pages to be selected.</span>
                    <p>Example: $Menu->select(1)</p>
                    <span>Will return an array with all pages with link_id=1</span>
                </li>
            </ul>
        
        <h3>Menu->item</h3>
            <span>Display single menu item as LI HTML element (&lt;li>HOME&lt;/li>).</span>
            
            <ul>
                <li>
                    <h4>Menu->item(id, array)</h4>
                    <span>id (integer): the id of the page</span>
                    <span>array (array): the entire row data selected from $Page->table for the current page</span>
                    <p>Example: Menu->item(1, array("id" => 1, "link_id" => 0, "theme" => NULL ...))</p>
                    <span>Will display an LI HTML element for the current page.</span>
                    <span>If the page link_id is equal to $this->link_id the class of the element will be menu-item, otherwise it will be sub-item. If the page has subpages attached, the element will also have class with-sub.</span>
                    <span>If the selected page has subpages, the Menu->pages function will be used to create submenu with the linked pages ($this->arr["submenu"] must be enabled).</span>
                </li>
            </ul>
            
        <h3>Menu->pages</h3>
            <span>Creates UL HTML container for the menu pages and list the pages with the Menu->item function.</span>
            
            <ul>
                <li>
                    <h4>Menu->pages(link_id=false)</h4>
                    <span>link_id (integer|boolean): link_id for start to select pages or false to use the default $this->link_id</span>
                    <p>Example: Menu->pages()</p>
                    <span>Creates UL HTML menu container element for the default $this->link_id pages. The UL element will have class top-menu.</span>
                    <p>Example: Menu->pages(1)</p>
                    <span>Creates UL HTML menu container element for all pages with link_id=1. The UL element will have class sub-menu.</span>
                </li>
            </ul>
            
        <h3>Menu->_</h3>
            <span>Creates full menu output.</span>
            <span>The id of the menu is menu-$this->menu</span>
            
            <ul>
                <li>
                    <h4>Menu->_()</h4>
                    <span>link_id (integer|boolean): link_id for start to select pages or false to use the default $this->link_id</span>
                    <p>Example: Menu->_()</p>
                    <span>Will create menu with $this->menu pages.</span>
                    <span>If $this->arr["submenu"]=true the menu will have subpages.</span>
                    <span>If $this->arr["mobile-open"] != false will create element with the passed code for opening the menu or other custom purposes.</span>
                    <span>If $this->arr["mobile-close"] != false will create element with the passed code for closing the menu or other custom purposes.</span>
                    <span>If $this->arr["ul-class"] != false will set the top menu class to passed value (instead of top-menu).</span>
                    <span>If $this->arr["query"] != false will select menu pages based on the passed SQL input (instead of the $this->menu name).</span>
                </li>
            </ul>
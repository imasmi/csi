<h1>Page.php</h1>
    <span>Finds site location based on the URL and other pages related functions.</span>
    <span>Location: system/module/Page/php/Page.php</span>
    <span>Namespace: system\module\Page\php</span>
    <span>Instance: new \module\Page\Page;</span>
    <span>Default instance of the class ($Page) is auto created.</span>

    <h2>Input parameters</h2>
        <h3>page_id (integer): the page id to create class instance around. If set to 0, page id is auto located by the URL value. Default is 0.</h3>
        <h3>Array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>table => string: to specify different table, than $Page->table to select pages from.</li>
            </ul>
            
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
            <span>Database table to select pages from. Default is the prefix_table if $this->arr["table"] is not specified.</span>
        
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
        
        <h3>Page->items</h3>
            <span>Select the current page or all pages related to the current page to find from.</span>
            
            <ul>
                <li>
                    <h4>Page->items(page_id)</h4>
                    <span>page_id: page_id to select items from</span>
                    <p>Example: $Page->items(1)</p>
                    <span>Will select all rows from the page table where id=1</span>
                    <p>Example: $Page->items(0) (where $_GET["url"] = "/")</p>
                    <span>Will select the homepage (a record in the $Page->table where type=homepage)</span>
                    <p>Example: $Page->items(0) (where $_GET["url"] = "/shop/shoes")</p>
                    <span>Will select all records in $Page->table where the value in current language = shoes (en=shoes)</span>
                    <span>If nothing found, the function returns an empty array.</span>
                </li>
            </ul>
            
        <h3>Page->id</h3>
            <span>Returns the id of the current page or 0 if nothing found.</span>
            
            <ul>
                <li>
                    <h4>Page->id()</h4>
                    <p>Example: $Page->id()</p>
                    <span>Will return the current id of the page based on the current URL.</span>
                    <span>If URL=/, it will return the id of the homepage (a record in the $Page->table where type=homepage).</span>
                </li>
            </ul>
            
        <h3>Page->_</h3>
            <span>Returns the id of the current page if no parameters are passed or an output based on the passed parameters.</span>
        
            <ul>
                <li>
                    <h4>Page->_(column=id, array=arrray)</h4>
                    <span>column (string): the column to retrieve result from or * for an array with all columns. Default is id.</span>
                    <span>array:</span>
                        <ul>
                            <li>id (integer): page_id to select columns for different page. Default is $this->id</li>
                        </ul>
                    <p>Example: $Page->_()</p>
                    <span>Will return the id of the current page based on the Page->id function.</span>
                    <p>Example: $Page->_("tag")</p>
                    <span>Will return the tag of the current page.</span>
                    <p>Example: $Page->_("*")</p>
                    <span>Will return all fields of the current page.</span>
                    <p>Example: $Page->_("tag", array("id" => 4))</p>
                    <span>Will return the tag of the page with id=4.</span>
                </li>
            </ul>
            
        <h3>Page->scheme</h3>
            <span>Returns an array with page scheme of the current page.</span>
            <span>In the page scheme are all database parent rows linked to the current page with the link_id values.</span>
            <span>If the current page has an id 7 and link_id 4, and the row with id 4 has a link_id 1, the selected rows from this function will be 1,4 and 7 in this order.</span>
        
            <ul>
                <li>
                    <h4>Page->scheme(id=false)</h4>
                    <span>column (string): the column to retrieve result from or * for an array with all columns. Default is id.</span>
                    <span>array:</span>
                        <ul>
                            <li>id (integer): page_id to select columns for different page. Default is $this->id</li>
                        </ul>
                    <p>Example: $Page->_()</p>
                    <span>Will return the id of the current page based on the Page->id function.</span>
                    <p>Example: $Page->_("tag")</p>
                    <span>Will return the tag of the current page.</span>
                    <p>Example: $Page->_("*")</p>
                    <span>Will return all fields of the current page.</span>
                    <p>Example: $Page->_("tag", array("id" => 4))</p>
                    <span>Will return the tag of the page with id=4.</span>
                </li>
            </ul>
            
        <h3>Page->path</h3>
            <span>Returns the file path of a page.</span>
        
            <ul>
                <li>
                    <h4>Page->path(id, dir=false)</h4>
                    <span>id (integer): the id of the page.</span>
                    <span>dir (boolean): if set to true returns the directory path without filename. Default is false.</span>
                    <p>Example: $Page->path(7)</p>
                    <span>Will return the path to the file with id 7 in $Page->table.</span>
                    <span>Example output: /about/team.</span>
                </li>
            </ul>
        
        <h3>Page->map</h3>
            <span>Creates page path map for a page to be used in SELECT elements and elsewhere needed.</span>
            <span>For page names are used the titles of the pages. If page titles are not provided, the id of the pages are displayed.</span>
            
            <ul>
                <li>
                    <h4>Page->map(id, separator=false)</h4>
                    <span>id (integer): the id of the page.</span>
                    <span>separator (string): Set the separator of the pages. Default separator is > </span>
                    <p>Example: $Page->map(14)</p>
                    <span>Will return path map for page with id 7 in $Page->table.</span>
                    <span>Example output: about > team > leader.</span>
                </li>
            </ul>
            
        <h3>Page->homepage</h3>
            <span>Returns id of the page with column type set to homepage in $Page->table or false if homepage is not set.</span>
            <span>The homepage is the page to display when the application domain is visited without an additional URL parameter.</span>
            
            <ul>
                <li>
                    <h4>Page->homepage()</h4>
                    <p>Example: $Page->homepage()</p>
                    <span>Example output: 1.</span>
                </li>
            </ul>
            
        <h3>Page->url</h3>
            <span>Returns URL link to page.</span>
            <span>The URLs are created based on the page language column or on the id if the language column is empty.</span>
            
            <ul>
                <li>
                    <h4>Page->url(id, language=false)</h4>
                    <span>id (integer): the id of the page.</span>
                    <span>language (string|boolean): if set to string, returns URL for specified language. Default is false.</span>
                    <p>Example: $Page->url(7)</p>
                    <span>Example output: /about-us/our-team.</span>
                </li>
            </ul>
        
        <h3>Page->http</h3>
            <span>Adds HTTP protocol to URL if missing.</span>
            
            <ul>
                <li>
                    <h4>Page->http(link)</h4>
                    <span>link (string): the URL to check.</span>
                    <p>Example: $Page->http("https://web.imasmi.com/manual")</p>
                    <span>Example output: https://web.imasmi.com/manual</span>
                    <p>Example: $Page->http("web.imasmi.com/manual")</p>
                    <span>Example output: http://web.imasmi.com/manual</span>
                </li>
            </ul>
            
        <h3>Page->current_file</h3>
            <span>Check the current page location in the system based on the retrieved URL from $_GET["url"].</span>
            <span>First checks if the system is in some module.</span>
            <span>Second checks if the system is in some plugin.</span>
            <span>Third checks if the system is in some database page from $Page->table.</span>
            <span>Fourth checks if the system is in some page custom page located in web/page folder based on the current url.</span>
            <span>If page is not found returns false.</span>
            
            <ul>
                <li>
                    <h4>Page->current_file()</h4>
                    <p>Example: $Page->current_file()</p>
                    <span>Example output: will return the page path based on the listed above criterias.</span>
                </li>
            </ul>
        
        <h3>Page->check_language</h3>
            <span>Checks the language of the loaded URL based on the first link in the $_GET["url"].</span>
            <span>If founded language is not the same as the current system language ($Language->_()) changes the system language. This way is possible to load different than current language URL by pasting it directly to the browser.</span>
            <span>Returns false if url language is not detected (and if $_GET["url"] is empty obviously).</span>
            
            <ul>
                <li>
                    <h4>Page->check_language()</h4>
                    <p>Example: $Page->check_language()</p>
                    <span>Will return the founded language based on the first link in the url. If founded language is not the same as the current language, will change the system language to display the page on the current language.</span>
                </li>
            </ul>
            
        <h3>Page->head</h3>
            <span>Creates autogenerated values to place in the HEAD HTML section of the application.</span>
            <span>Adds title, favicon, description, keywords, og elements for social medias (title, type, url, description, og image) if provided for the current page. This options can be set in Settings > Page > Settings from WEB admin.</span>
            <span>Adds robots index,follow|noindex,nofollow option. This setting can be changed in Settings > Setting from WEB admin. Default is index,follow.</span>
            <span>$Page->head() is autoincluded in the web/head.php file on system installation.</span>
            
            <ul>
                <li>
                    <h4>Page->head()</h4>
                    <p>Example: $Page->head()</p>
                    <span>Adds HTML HEAD elements to web application. Must be places in web/head.php file.</span>
                </li>
            </ul>
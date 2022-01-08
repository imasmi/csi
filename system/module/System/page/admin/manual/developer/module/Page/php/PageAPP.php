<h1>PageAPP.php</h1>
    <span>PageAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Page/php/PageAPP.php</span>
    <span>Namespace: system\module\Page\php</span>
    <span>Instance: new \module\Page\PageAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>
 
    <h2>Variables</h2>
    
        <h3>PageAPP->PDO</h3>
            <span>A variable to use for database PDO connection.</span>
        
        <h3>PageAPP->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>PageAPP->Query</h3>
            <span>A variable with instance of \system\Database class.</span>
            
        <h3>PageAPP->Form</h3>
            <span>A variable with instance of \module\Module\Module class.</span>
            
        <h3>PageAPP->Page</h3>
            <span>A variable with instance of \module\Page\Page class.</span> 
        
    <h2>Functions</h2>
        <h3>PageAPP->url_format</h3>
            <span>Convert string to URL supported format.</span>
            <span>Removes special characters and converts white spaces to dashes.</span>
            <ul>
                <li>
                    <h4>PageAPP->url_format()</h4>
                    <p>Example: $PageAPP->url_format("h$me p@ge")</p>
                    <span>Example output: hme-pge</span>
                </li>
            </ul>
            
        <h3>PageAPP->select</h3>
            <span>SELECT HTML drop down menu to select page from $Page->table.</span>
            <ul>
                <li>
                    <h4>PageAPP->select(name, select=false, query=false)</h4>
                    <span>name (string): the name tag of the HTML SELECT element.</span>
                    <span>select (integer|boolean): a value to compare results with and select if matched. Default is false.</span>
                    <span>query (string|boolean): SQL command to select custom $Page->table rows. If not provided all pages are selected. Default is false.</span>
                    <p>Example: $PageAPP->select("page_select", 4)</p>
                    <span>Will create drop down SELECT HTML element with name tag=page_select and will select option with value=4 if it is in the options list.</span>
                </li>
            </ul>
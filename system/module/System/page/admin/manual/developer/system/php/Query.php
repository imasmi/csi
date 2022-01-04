<h1>Query.php</h1>
    <span>Query is class for database automated operations such as insert, update, remove and others.</span>
    <span>Query use the PHP Data Objects (PDO) extension to access the database. A connections are made thru the $PDO built-in instance for communicating with the database.</span>
    <span>$Query - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/php/Query.php</span>
    
    <h3>Query->insert</h3>
        <span>Insert database rows with column values parsed with an array.</span>
        <ul>
            <li>
                <h4>Query->insert(array, table="module")</h4>
                <span>array: an array with column names as keys and column values as values. Example: array("tag" => "web", "type" => "homepage")</span>
                <span>table (optional): the table to select in. If left unfilled and the current url location is in some module or plugin, the system will automatically resolve the default module or plugin table. Example: web_page (will search for the selector value in table web_page)</span>
                
                <p>Example: \system\Query::insert(array("tag" => "web", "type" => "homepage"), "web_page");</p>
                <span>The above example will insert a row in web_page table with web value in column tag and homepage value in column type.</span>
            </li>
        </ul>
    <h3>Query->update</h3>
        <span>Update database row with parsed array as keys for columns to be updated and values as new values of the columns.</span>
        <ul>
            <li>
                <h4>Query->update(array, selector value, selector column="id", table="module", selector type="=")</h4>
                <span>array: an array with column names as keys and column values as values. Example: array("tag" => "web", "type" => "homepage")</span>
                <span>selector value: specified value to select table row to be updated. Example: 3 (will select row with value 3 in it)</span>
                <span>selector column (optional): the column where the selector value to be searched. Default is id. Example: age (will search for the selector value in column with name - age)</span>
                <span>table (optional): the table to select in. If left unfilled and the current url location is in some module or plugin, the system will automatically resolve the default module or plugin table. Example: web_page (will search for the selector value in table web_page)</span>
                <span>selector type (optional): the symbol for the query selector.Default is =. Example: LIKE (will create LIKE selecting query)</span>
                
                <p>Example: \system\Query::update(array("tag" => "web", "type" => "homepage"), "3", "id", "web_page");</p>
                <span>Will update a row with id = '3' in web_page table with web value in column tag and homepage value in column type.</span>
                <p>Example: \system\Query::update(array("tag" => "web", "type" => "homepage"), "new", "type", "web_page", "LIKE");</p>
                <span>Will update a row with type LIKE 'new' in web_page table with web value in column tag and homepage value in column type.</span>
            </li>
        </ul>
    <h3>Query->loop</h3>
        <span>Loop thru the system table (prefix_page, prefix_file, prefix_setting, prefix_text) and returns an array with all linked rows.</span>
        <span>A query is parsed for selecting start point.</span>
        <ul>
            <li>
                <h4>Query->loop(start selector query, table=false)</h4>
                <span>start selector query: a query for start loop selecting point. Example: SELECT * FROM web_page WHERE tag='web'</span>
                <span>table (optional): this function will auto detect the start selecting table for one table queries. In case in more complex queries where more than one table is selected the start selecting table must be specified. Default is id. Example: web_page</span>
                
                <p>Example: \system\Query::loop("SELECT * FROM web_page WHERE tag='web'");</p>
                <span>Will return an array with all linked rows to all rows in web_page table where tag='web' from the system tables.</span>
            </li>
        </ul>
    <h3>Query->cleanup</h3>
        <span>Will perform loop cleanup to system tables, based on start row.</span>
        <span>If rows in file system table are founded, all files and folders linked to the rows will be removed.</span>
        <ul>
            <li>
                <h4>Query->cleanup(selector value, selector column="id", table="module", selector type="=")</h4>
                <span>selector value: specified value to select row to be start deleting point. Example: 3 (will select something with value 3 in it)</span>
                <span>selector column (optional): the column where the selector value to be searched. Default is id. Example: age (will search for the selector value in column with name - age)</span>
                <span>table (optional): the table to select in as an start point. If left unfilled and the current url location is in some module or plugin, the system will automatically resolve the default module or plugin table. Example: web_page (will search for the selector value in table web_page)</span>
                <span>selector type (optional): the symbol for the query selector.Default is =. Example: LIKE (will create LIKE selecting query)</span>
                
                <p>Example: \system\Query::cleanup("3", "id", "web_page");</p>
                <span>Will perform a loop cleanup of the system tables with the following query as starting point: DELETE FROM web_page WHERE id='3'.</span>
                <p>Example: \system\Query::cleanup("homepage", "type", "web_page", "LIKE");</p>
                <span>Will perform a loop cleanup of the system tables with the following query as starting point: DELETE FROM web_page WHERE type LIKE 'homepage'.</span>
            </li>
        </ul>
    <h3>Query->column_group</h3>
        <span>Return array with unique values from specified table column.</span>
        <ul>
            <li>
                <h4>Query->column_group(column, table=false)</h4>
                <span>column: a column to fecth row values from. Example: type</span>
                <span>table (optional): the table to select in as an start point. If left unfilled and the current url location is in some module or plugin, the system will automatically resolve the default module or plugin table. Example: web_page (will search for the selector value in table web_page)</span>
                
                <p>Example: \system\Query::column_group("type", "web_page");</p>
                <span>Will return an array with all unique values from column type in web_page table.</span>
            </li>
        </ul>
    <h3>Query->table</h3>
        <span>Return table with prefix and name if name specified or finds default table for module or plugin if name is not specified.</span>
        <ul>
            <li>
                <h4>Query->table(name=false)</h4>
                <p>Example: \system\Query::table("page");</p>
                <span>Will return prefix_page.</span>
                <p>Example: \system\Query::table();</p>
                <span>Will return default table name if current url is located in module or plugin.</span>
            </li>
        </ul>
    <h3>Query->top_id</h3>
        <span>Return top id from linked rows.</span>
        <span>This function can be applied only for integer values.</span>
        <ul>
            <li>
                <h4>Query->top_id(selector value, link column="link_id", column="id", table=false)</h4>
                <span>selector value: specified value to select for starting point in the table. Example: 3 (will select something with value 3 in it)</span>
                <span>link column (optional): a column to link with the top rows. Default is link_id. Exaple: page_id</span>
                <span>column (optional): the column where the top integer value will be searched. Default is id. Exaple: row</span>
                <span>table (optional): the table to select in the top id. If left unfilled and the current url location is in some module or plugin, the system will automatically resolve the default module or plugin table. Example: web_page (will search top value in table web_page)</span>
                
                <p>Example: \system\Query::top_id(3, "link_id", "id", "web_page");</p>
                <span>Will return top id value of all linked parent rows of start row with id='3'. The link column will be link_id in web_page table.</span>
            </li>
        </ul>
<h1>Core.php</h1>
    <span>Core class containts functions for system information, structure building, path resolving and others.</span>
    <span>Core class is the vital for ImaSmi Web and is the only class that is loaded before the structure of the system is created.</span>
    <span>$Core - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/Core.php</span>

    <h3>Core->domain</h3>
        <span>Return the current domain location with the used HTTP scheme.</span>
        <ul>
            <li>
                <h4>Core->domain()</h4>
                <p>Example: \system\Core::domain();</p>
                <span>Will return something like: https://web.imasmi.com</span>
            </li>
        </ul>
    <h3>Core->list_dir</h3>
        <span>Recursively listing directory.</span>
        <span>Return array with paths to directories and files finded.</span>
        <ul>
            <li>
                <h4>Core->list_dir(path, array=array())</h4>
                <span>path: a path to select directories and files within. Example: /web/file</span>
                <span>array (optional):</span>
                    <ul>
                        <li>select (string) file|dir: file option selects only files and dir only directories. If not set the function will select both files and directories.</li>
                        <li>recursive (boolean): specify to list directories recursively or not. If not set the functions lists recursively.</li>
                        <li>multidimensional (boolean): if set to true the output will be multidimensional array, otherwise it will be one-dimensional output.</li>
                    </ul>
                <p>Example: \system\Core::list_dir("/web/file");</p>
                <span>Will select all directories and files in /web/file directory and will return an array with the selected paths.</span>
            </li>
        </ul>
    <h3>Core->path_resolve</h3>
        <span>Check if path exists in the filesystem.</span>
        <ul>
            <li>
                <h4>Core->path_resolve(path)</h4>
                <p>Example: \system\Core::path_resolve("/web/page/home.php");</p>
                <span>Will return /web/page/home.php if home.php file exists in /web/page directory or false if it doesn't exists.</span>
            </li>
        </ul>
    <h3>Core->links</h3>
        <span>Returns array with current URL path segments exploded.</span>
        <span>Get parameters are ignored.</span>
        <ul>
            <li>
                <h4>Core->links()</h4>
                <p>Example: print_r(\system\Core::links()) when in URL /home/hello/welcome;</p>
                <span>Will output - array(0 => "home", "1" => "hello", 2 => "welcome").</span>
            </li>
        </ul>
    <h3>Core->path_slice</h3>
        <span>Slice parts from given path.</span>
        <span>This function use array_slice php function to remove parts from the path. For more information about array_slice php function click <a href="https://www.php.net/manual/en/function.array-slice.php" target="blank">here</a>.</span>
        <ul>
            <li>
                <h4>Core->path_slice(path, start=false, end=false)</h4>
                <span>path: an URL path to be sliced. Example: /home/hello/welcome</span>
                <span>start (optional): if presented will set slice start offset. If start value is non-negative, the sequence will start at that point in the array. If start value is negative, the sequence will start that far from the end of the array. Example: -1</span>
                <span>end (optional): if presented will set slice length end point. If end is presented and is positive, then the slice will have up to that many elements in it. If the array is shorter than the end length, then only the available array elements will be present. If end is given and is negative then the slice will stop that many elements from the end of the array.</span>
                <p>Example: \system\Core::path_slice("/home/hello/welcome", 1, 2);</p>
                <span>Will return /hello/welcome.</span>
                <p>Example: \system\Core::path_slice("/home/hello/welcome", 1, 1);</p>
                <span>Will return /hello.</span>
            </li>
        </ul>
    <h3>Core->this_path</h3>
        <span>Returns cuurent URL path.</span>
        <span>If start or end options are presented, the path is sliced using Core->path_slice function.</span>
        <ul>
            <li>
                <h4>Core->this_path(start=false, end=false)</h4>
                <span>start (optional): if presented will set slice start offset. If start value is non-negative, the sequence will start at that point in the array. If start value is negative, the sequence will start that far from the end of the array. Example: -1</span>
                <span>end (optional): if presented will set slice length end point. If end is presented and is positive, then the slice will have up to that many elements in it. If the array is shorter than the end length, then only the available array elements will be present. If end is given and is negative then the slice will stop that many elements from the end of the array.</span>
                <p>Example: \system\Core::this_path() in URL /home/hello/welcome;</p>
                <span>Will return /home/hello/welcome.</span>
                <p>Example: \system\Core::this_path(1, 2) in URL /home/hello/welcome;</p>
                <span>Will return /hello/welcome.</span>
                <p>Example: \system\Core::this_path(-1) in URL /home/hello/welcome;</p>
                <span>Will return /home/hello.</span>
            </li>
        </ul>
    <h3>Core->query_path</h3>
        <span>Returns path to the mirror query location.</span>
        <span>If start or end options are presented, the path is sliced using Core->path_slice function.</span>
        <ul>
            <li>
                <h4>Core->query_path(start=false, end=false)</h4>
                <span>start (optional): if presented will set slice start offset. If start value is non-negative, the sequence will start at that point in the array. If start value is negative, the sequence will start that far from the end of the array. Example: -1</span>
                <span>end (optional): if presented will set slice length end point. If end is presented and is positive, then the slice will have up to that many elements in it. If the array is shorter than the end length, then only the available array elements will be present. If end is given and is negative then the slice will stop that many elements from the end of the array.</span>
                <p>Example: \system\Core::query_path() in URL /home/hello/welcome;</p>
                <span>Will return /query/home/hello/welcome.</span>
                <p>Example: \system\Core::query_path(1, 2) in URL /home/hello/welcome;</p>
                <span>Will return /query/hello/welcome.</span>
                <p>Example: \system\Core::query_path(-1) in URL /home/hello/welcome;</p>
                <span>Will return /query/home/hello.</span>
            </li>
        </ul>
    <h3>Core->url</h3>
        <span>Return the base URL home directory for the application.</span>
        <span>This function is useful to specify start point of absolute paths in the system for URLs, file locations and others.</span>
        <span>This function awlays add trailing slash (/) at the end of the output.</span>
        <ul>
            <li>
                <h4>Core->url()</h4>
                <p>Example: \system\Core::query_path() where application is installed in https://web.imasmi.com;</p>
                <span>Will return /</span>
                <p>Example: \system\Core::query_path() where application is installed in https://web.imasmi.com/application;</p>
                <span>Will return /application/</span>
            </li>
        </ul>
    <h3>Core->doc_root</h3>
        <span>Return the document root of the applciation.</span>
        <ul>
            <li>
                <h4>Core->doc_root()</h4>
                <p>Example: \system\Core::doc_root() called from any place within the app where application is installed in folder /home/www/public_html;</p>
                <span>Will return /home/www/public_html</span>
            </li>
        </ul>
    <h3>Core->credit</h3>
        <span>Return ImaSmi Web credit label.</span>
        <ul>
            <li>
                <h4>Core->credit()</h4>
                <p>Example: \system\Core::credit();</p>
                <span>Will return &lt;div class="credit-system">Developed by &lt;a class="name_system" href="https://imasmi.com" target="_blank" title="ImaSmi software and development">ImaSmi&lt;/a>&lt;/div></span>
            </li>
        </ul>
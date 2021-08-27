<h1>Language.php</h1>
    <span>System wide information and explanation functions</span>
    <span>Location: system/module/Language/php/Language.php</span>
    <span>Namespace: system\module\Language\php</span>
    <span>Instance: new \system\module\Language\php\Language;</span>
    <span>Default instance of the class ($Language) is auto created and ready to use on system load.</span>
    <span>Current language in use is stored in cookie - $_COOKIE["language"]</span>
    
    <h2>Variables</h2>
        <h3>Language->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            <ul>
                <li>
                    <h4>this->Core</h4>
                    <p>Example: $this->Core->domain();</p>
                </li>
            </ul>     
        
        <h3>Language->ini_path</h3>
            <span>Full path of the available languages configuration INI file.</span>
            <span>Value: /web/ini/language.ini</span>
            
        <h3>Language->ini</h3>
            <span>Parsed languages configuration from the ini file.</span>
        
        <h3>Language->items</h3>
            <span>Array with all enabled languages in the system from the languages INI file where on-off=1</span>
        
    <h2>Functions</h2>
        <h3>Language->items</h3>
            <span>Select all added languages to the system.</span>
            <span>Returns array of file records selected from $this->ini with Language => Abbrevition couples.</span>
            <ul>
                <li>
                    <h4>Language->items(show_all=false)</h4>
                    <span>show_all: select even disabled languages with on-off=0 in INI file. Default is false.</span>
                    <p>Example: print_r($Language->items())</p>
                    <span>Example output: array("English" => "en", "Bulgarian" => "bg")</span>
                </li>
            </ul>
        
        <h3>Language->changer</h3>
            <span>Creates language changer with all enabled languages.</span>
            <span>For easy one line integration.</span>
            <ul>
                <li>
                    <h4>Language->changer(array=array())</h4>
                    <span>array:</span>
                        <ul>
                            <li>name (boolean): show full name of the language instead code.</li>
                        </ul>
                    <p>Example: $Language->changer()</p>
                    <span>Creates a language changer with all enabled languages</span>
                </li>
            </ul>
            
        <h3>Language->table</h3>
            <span>An array with all database tables where language fields are available.</span>
            <span>Currently file, page, text and setting tables.</span>
            <ul>
                <li>
                    <h4>Language->table()</h4>
                    <p>Example: print_r($Language->table())</p>
                    <span>Example output: array("file", "page", "text", "setting")</span>
                </li>
            </ul>
            
        <h3>Language->_</h3>
            <span>Current language in use (language code returned).</span>
            <ul>
                <li>
                    <h4>Language->_()</h4>
                    <p>Example: print_r($Language->table())</p>
                    <span>Example output: en</span>
                </li>
            </ul>
<h1>CodeAPP.php</h1>
    <span>CodeAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Code/php/CodeAPP.php</span>
    <span>Namespace: system\module\Code\php</span>
    <span>Instance: new \system\module\Code\php\CodeAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>

    <h2>Variables</h2>
        <span>This magic PHP function is called when a new instance of the class is created and set some data for usage inside the whole object.</span>
        <h3>CodeAPP->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            <ul>
                <li>
                    <h4>CodeAPP->Core</h4>
                    <p>Example: $this->Core->domain();</p>
                </li>
            </ul>
        <h3>CodeAPP->FileAPP</h3>
            <span>A variable with instance of \system\module\File\php\FileAPP class.</span>
            <ul>
                <li>
                    <h4>CodeAPP->FileAPP</h4>
                    <p>Example: $this->FileAPP->copy_dir("/web", "/new_web");</p>
                </li>
            </ul>
        
    <h2>Functions</h2>
        <h3>CodeAPP->find</h3>
            <span>Finds string occurence inside given path recursively and return array with matched paths.</span>
            <span>In the returned array keys are paths where string occures and values are numbers for how many times the string occures in the matched location.</span>
            <ul>
                <li>
                    <h4>CodeAPP->find(search string, path, file type=*)</h4>
                    <span>search string: a string to be searched for. Example: find this string</span>
                    <span>path: path location to be searched recursively. Example: /web</span>
                    <span>file type: if specified only files from this type will be searched. Example: php</span>
                    <p>Example: $CodeAPP->find("test", "/web", "js")</p>
                    <span>Will return array with all javascript files paths where the string - test occures as keys, and numbers how many times it occures as values.</span>
                    <span>Example output: array("/web/js/test.js" => 3, "/web/custom.js" => 1)</span>
                </li>
            </ul>
        <h3>CodeAPP->replace</h3>
            <span>Replace string occurences inside given path recursively and return array with information about successful replacements.</span>
            <span>This function performs only case-sensitive replacements.</span>
            <ul>
                <li>
                    <h4>CodeAPP->replace(search string, replace string, path, file type=*)</h4>
                    <span>search string: a string to be searched for replacement. Example: find this string</span>
                    <span>replace string: a string to replace the search string. Example: new string text</span>
                    <span>path: path location to be searched recursively. Example: /web</span>
                    <span>file type: if specified only files from this type will be searched. Example: php</span>
                    <p>Example: $CodeAPP->replace("My name is Peter", "I am Peter", "/web", "js")</p>
                    <span>Will replace all occurences of the string My name is Peter with I am Peter inside every javasrcipt file in /web folder.</span>
                    <span>Example output: array(0 => "Operation succeeded in  /web/js/test.js where 3 occurences was found", 1 => "Operation succeeded in  /web/custom.js where 1 occurences was found")</span>
                </li>
            </ul>
        <h3>CodeAPP->find_between</h3>
            <span>Finds string occurence inside given path recursively between start string and end string and return array with finded contents.</span>
            <span>This function performs only case-sensitive searches.</span>
            <ul>
                <li>
                    <h4>CodeAPP->find_between(start string, end string, path, file type=*)</h4>
                    <span>start string: a string for search start point. Example: #index{</span>
                    <span>end string: a string for search end point. Example: }</span>
                    <span>path: path location to be searched recursively. Example: /web</span>
                    <span>file type: if specified only files from this type will be searched. Example: php</span>
                    <p>Example: $CodeAPP->find_between("#test{", "}", "/web", "css")</p>
                    <span>Will search every css file inside /web directory and return an array with all finded content between #test{ and }.</span>
                    <span>Example output: array(0 => "width: 20px; position: relative;")</span>
                </li>
            </ul>
        <h3>CodeAPP->edit_css</h3>
            <span>This function edit CSS specified rule styles.</span>
            <span>Only the specified styles are edited. All others defined rules are left unchanged after function execution.</span>
            <ul>
                <li>
                    <h4>CodeAPP->edit_css(css style selector, array with CSS styles, destination css file=false)</h4>
                    <span>css style selector: a css rule to be edited. Example: #index #test</span>
                    <span>array with CSS styles: an array with styles as keys and new style values as values. Example: array("width"=> "20px", "position" => "relative")</span>
                    <span>destination css file: css file where the presented rule to be edited. Default is /web/css/custom.css. Example: /web/test.css</span>
                    <p>Example: $CodeAPP->edit_css("#index #test", array("width"=> "20px", "position" => "relative"), "/web/test.css")</p>
                    <span>This example will set styles - width: 20px;position: relative; of #index #test within file /web/test.css</span>
                    <span>If styles doesn't exist they will be added, otherwise they will be edited.</span>
                </li>
            </ul>
        <h3>CodeAPP->special_characters_check</h3>
            <span>Checks given string for special characters.</span>
            <span>It returns true if special characters are finded and false if not.</span>
            <span>Special characters: ^£$%&*()}{@#~?><>,|=¬]/</span>
            <ul>
                <li>
                    <h4>CodeAPP->special_characters_check(string)</h4>
                    <p>Example: $CodeAPP->special_characters_check("Hello$world#")</p>
                    <span>This example return true as characters $ and # are treated as special.</span>
                </li>
            </ul>
        <h3>CodeAPP->special_characters_remove</h3>
            <span>Remove special characters from a string.</span>
            <span>Special characters: ^£$%&*()}{@#~?><>,|=¬]/</span>
            <ul>
                <li>
                    <h4>CodeAPP->special_characters_remove(string)</h4>
                    <p>Example: $CodeAPP->special_characters_remove("Hello$world#")</p>
                    <span>This example will return - Helloworld.</span>
                </li>
            </ul>
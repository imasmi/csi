<h1>Ini.php</h1>
    <span>Ini class for working with ini settings files.</span>
    <span>$Ini - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/php/Ini.php</span>
    <h3>Ini->format</h3>
        <span>Converts associative array with key-value pairs to ini setting output. Multidimensional array can be parsed for output with section names.</span>
        <ul>
            <li>
                <h4>Ini->format(array)</h4>
                <p>Example: \system\Ini::format(array("name" => "Peter", "age" => "18"));</p>
                <span>The example above will output: <br/><br/>name = peter <br/> age = 18</span>
                <p>Example: \system\Ini::format("Person" = array("name" => "Peter", "age" => "18"));</p>
                <span>The example above will output: <br/><br/>[Person]<br/>name = peter <br/> age = 18</span>
            </li>
        </ul>
    <h3>Ini->save</h3>
        <span>Converts array into ini output and save it in file.</span>
        <ul>
            <li>
                <h4>Ini->save(path to save, array, flags=false)</h4>
                <span>path to save: a file location where to save ini settings. Example: /web/ini/setup.ini</span>
                <span>array: an array with settings. The array will be converted to ini output with the Ini.format function. Example: array("name" => "Peter", "age" => "18")</span>
                <span>flags (optional): this function use file_put_contents php function to write into the file and all function flags are available to be used. For information with examples click <a href="https://www.php.net/manual/en/function.file-put-contents.php">here</a>.</span>
                <p>Example: \system\Ini::save("/web/ini/setup.ini","Person" = array("name" => "Peter", "age" => "18"), FILE_APPEND);</p>
                <span>The example above will append at the end of the file /web/ini/setup.ini the following output: <br/><br/>[Person]<br/>name = peter <br/> age = 18</span>
            </li>
        </ul>
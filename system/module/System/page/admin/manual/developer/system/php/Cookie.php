<h1>Cookie.php</h1>
    <span>Cookie class to conrol cookies.</span>
    <span>$Cookie - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/php/Cookie.php</span>
<h3>Cookie->set</h3>
    <span>Set cookie with specified name and value.</span>
    <ul>
        <li>
            <h4>Cookie->set(name, value, options=array(expires|path)</h4>
            <span>name: name of the cookie. Example: language</span>
            <span>value: value of the cookie. Example: english</span>
            <span>options (optional): set cookie options. expires: a timestamp when the cookie will expire, default is is after 30 days from now on. path: set cookie url path, default is / for the whole domain.</span>
            <p>Example: \system\Cookie::set("language", "english", array("expires" => time() + 60, "path" => "/home"));</p>
            <span>The example above will set cookie with name language and value english. The cookie will be valid only for url /home and will expire after 60 seconds.</span>
        </li>
    </ul>
<h3>Cookie->remove</h3>
    <span>Remove cookie with specified name.</span>
    <ul>
        <li>
            <h4>Cookie->remove(name, options=array(path)</h4>
            <span>name: name of the cookie. Example: language</span>
            <span>options (optional): specify cookie options. path: specify cookie url path, default is / for the whole domain.</span>
            <p>Example: \system\Cookie::remove("language", array("path" => "/home"));</p>
            <span>The example above will remove cookie with name language from the url /home.</span>
        </li>
    </ul>
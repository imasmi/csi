<h1>Module.php</h1>
    <span>A class with functions for system modules processing operations.</span>
    <span>$Module - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/php/Module.php</span>
    
    <h3>Module->_</h3>
        <span>Checks if current URL location is part of the system module.</span>
        <ul>
            <li>
                <h4>Module->_()</h4>
                <p>Example: print_r($Module->_()) when at url /User/login</p>
                <span>User is system module and the example will output User.</span>
                <p>Example: print_r($Module->_()) when at url /Home/login</p>
                <span>Home is not system module and the example will not print anything to the screen, as $Module->_() will return false.</span>
            </li>
        </ul>
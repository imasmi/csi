<h1>Info.php</h1>
    <span>System wide information and explanation functions</span>
    <span>Location: system/module/Info/php/Info.php</span>
    <span>Namespace: system\module\Info\php</span>
    <span>Instance: new \system\system\Info;</span>
    <span>Default instance of the class ($Info) is auto created and ready to use on system load.</span>
    
    <h2>Functions</h2>
        <h3>Info->_</h3>
            <span>Create in place information label with additional popup explanation.</span>
            <span>This function allows to explain functionality, give hints and other information at needded locations in the system.</span>
            <ul>
                <li>
                    <h4>Info->_(explanation)</h4>
                    <p>Example: \system\Info::_("This is information in place information label and can be putted everywhere.")</p>
                    <span>Will add in place question mark with popup information label with the inserted text when clicked.</span>
                </li>
            </ul>
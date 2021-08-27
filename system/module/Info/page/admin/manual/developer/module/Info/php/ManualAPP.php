<h1>ManualAPP.php</h1>
    <span>ManualAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Info/php/ManualAPP.php</span>
    <span>Namespace: system\module\Info\php</span>
    <span>Instance: new \system\module\Info\php\ManualAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>

    <h2>Variables</h2>
        <h3>ManualAPP->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            
        <h3>ManualAPP->filetypes</h3>
            <span>Array with application filetypes used in the manual.</span>
            
        <h2>Functions</h2>
        
        <h3>ManualAPP->menu</h3>
            <span>Creates recursive menu automatically based on directories and files in given location.</span>
            
            <ul>
                <li>
                    <h4>ManualAPP->menu(path)</h4>
                    <p>Example: ManualAPP->menu("/system/module/Info/page/manual/developer/module/User")</p>
                    <span>The example will create a menu for the given path with the retrieved files and direcotries.</span>
                </li>
            </ul>
        
        <h3>ManualAPP->path_id</h3>
            <span>Create id based on given path.</span>
            <span>The path elements are separated by hyphen.</span>
            
            <ul>
                <li>
                    <h4>ManualAPP->path_id(path)</h4>
                    <p>Example: ManualAPP->path_id("developer/module/User")</p>
                    <span>Example output: developer-module-User.</span>
                </li>
            </ul>
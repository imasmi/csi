<h1>ZipAPP.php</h1>
    <span>Creates and extracts ZIP archives</span>
    <span>ZipAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/File/php/ZipAPP.php</span>
    <span>Namespace: system\module\File\php</span>
    <span>Instance: new \module\File\ZipAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>

    <h2>Input parameters</h2>
        <h3>1. File: string</h3>
            <span>Zip file name to create or work with</span>
        <h3>2. Path: string</h3>
            <span>Zip file location to create or work with</span>
        <h3>2. Array</h3>
            <span>An array with additional parameters to set object enviorment.</span>
            <ul>
                <li>include => (string|array) single directory/file or array of directories/files to include in ZIP archive.</li>
                <li>exclude => (string|array) single directory/file or array of directories/files to exclude from ZIP archive.</li>
            </ul>
            <p>Example: $Shop_file = new \module\File\File(42, array("plugin" => "Shop"));</p>
    
    <h2>Variables</h2>
        <span>This magic PHP function is called when a new instance of the class is created and set some data for usage inside the whole object.</span>
        <h3>ZipAPP->Core</h3>
            <span>A variable with instance of \system\Core class.</span>
            <ul>
                <li>
                    <p>Example: \system\Core::domain();</p>
                </li>
            </ul>
        <h3>ZipAPP->zip</h3>
            <span>Isnstance of PHP ZipArchive Class.</span>
            <ul>
                <li>
                    <p>Example: $this->zip->open($this->file, \ZipArchive::CREATE);</p>
                </li>
            </ul>
        <h3>ZipAPP->file</h3>
            <span>Contains the passed file parameter from the initialization of the class</span>
        <h3>ZipAPP->path</h3>
            <span>Contains the passed path parameter from the initialization of the class</span>
        <h3>ZipAPP->arr</h3>
            <span>Contains the passed array from the initialization of the class</span>
        
    <h2>Functions</h2>
        <h3>ZipAPP->create</h3>
            <span>Creates new ZIP archive file.</span>
            <ul>
                <li>
                    <h4>ZipAPP->create()</h4>
                    <p>Example: $ZipAPP->create()</p>
                    <span>Will create ZIP archive in location = $this->path and name = $this->name. Any optional files and directories passed in $this->arr will be included/excluded.</span>
                </li>
            </ul>
            
        <h3>ZipAPP->unzip</h3>
            <span>Extract ZIP archive.</span>
            <ul>
                <li>
                    <h4>ZipAPP->unzip()</h4>
                    <p>Example: $ZipAPP->unzip()</p>
                    <span>Will extract ZIP with name = $this->name in location = $this->path.</span>
                </li>
            </ul>
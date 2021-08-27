<h1>Structure</h1>
    <span>The filesystem structure of ImaSmi Web is simple and once mastered, it comes in great help in web applications development.</span>
    <span>There are some rules to follow that may seem complicated at first, but they are extremely easy to get used to in practice.</span>
<h2>Folders</h2>
    <ul>
        <li>
            <h4>Data</h4>
            <p>This folder is not present at installation of the system. It stores system data such as backups, logs, cache files and etc. It will be created automatically by the system when such data is available.</p>
        </li>
        <li>
            <h4>Plugin</h4>
            <p>This folder is also not available at the installation of the system. It will be created when a plugin is installed from Webstore or a custom plugin is created with the Plugin module. It stores all installed plugins.</p>
        </li>
        <li>
            <h4>System</h4>
            <p>System folder contains all system files and the whole ImaSmi Web logic. It is the engine of the system. It is not recommended to modify this folder, because any changes here will be totally wiped out after System update of ImaSmi Web.</p>
        </li>
        <li>
            <h4>Web</h4>
            <p>This is where current theme is applied. In this folder are all custom pages, files, styles and other things to create and shape up a web application of any kind.</p>
        </li>
    </ul>

<h2>Model</h2>
    <span>ImaSmi Web follows a strictly defined model for its filesystem. This pattern is applied in every folder in the system (an exception is the Data folder, because it stores various system data for custom purposes).</span>
    <span>This filesystem pattern is essential for ImaSmi Web as a framework. It is created to standardizes, speed up and ease the process of creating web applications. Autoinclusion of files of different types and automated URL controller system eliminate the need to create application logic and allow to jump right into the development process.</span>
    
<h2>Model folders</h2>
    <span>There are four places where the pattern is applied as standard in exactly the same way and they are:</span>
    <ul>
        <li>
            <h4>System</h4>
            <p>Location: system/</p>
        </li>
        <li>
            <h4>Module (this applies to every module home folder)</h4>
            <p>Location: system/module/Module_name</p>
        </li>
        <li>
            <h4>Plugin folder (this applies to every plugin home folder)</h4>
            <p>Location: plugin/Plugin_name</p>
        </li>
        <li>
            <h4>Web</h4>
            <p>Location: web/</p>
        </li>
    </ul>
    
<h2>Model pattern</h2>
    <span>Every model folder follows this model pattern and can contain the following files and folders. Names of files and folders are case-sensitive:</span>

<h3>Folders</h3>
    <ul>
        <li>
            <h4>css</h4>
            <p>Every Cascading Style Sheets  (css) file placed in this folder will be auto-included by the system in alphabetic ascending order. These rules applies for all subfolders also.</p>
            <p>Example: alfa.css, beta.css, gama.css will be auto-included in the above order.</p>
            <p>All files that contains APP as a name end before filetype will be auto-included only if user of type admin is logged in the system.</p>
            <p>Example: alfaAPP.css, betaAPP.css, gamaAPP.css will be auto-included in the above order only if user of type admin is logged in the system.</p>
        </li>
        <li>
            <h4>file</h4>
            <p>This folder is used to store files for modules, plugins and web folder. This files can be stored by some of the system file handling functions or manually.</p>
        </li>
        <li>
            <h4>ini</h4>
            <p>This folder is used to store setting files of type INI for system, modules, plugins and theme. This files can be stored by some of the system ini handling functions or manually.</p>
        </li>
        <li>
            <h4>js</h4>
            <p>Every JavaScript (js) file placed in this folder will be auto-included by the system in alphabetic ascending order. These rules applies for all subfolders also.</p>
            <p>Example: alfa.js, beta.js, gama.js will be auto-included in the above order.</p>
            <p>All files that contains APP as a name end before filetype will be auto-included only if user of type admin is logged in the system.</p>
            <p>Example: alfaAPP.js, betaAPP.js, gamaAPP.js will be auto-included in the above order only if user of type admin is logged in the system.</p>
        </li>
        <li>
            <h4>php</h4>
            <p>Every PHP: Hypertext Preprocessor (php) file placed in this folder will be auto-included by the system in alphabetic ascending order. These rules applies for all subfolders also.</p>
            <p>Example: alfa.php, beta.php, gama.php will be auto-included in the above order.</p>
            <p>All files that contains APP as a name end before filetype will be auto-included only if user of type admin is logged in the system.</p>
            <p>Example: alfaAPP.php, betaAPP.php, gamaAPP.php will be auto-included in the above order only if user of type admin is logged in the system.</p>
        </li>
        <li>
            <h4>page</h4>
            <p>This folder is used to store user-landing pages in the system such as HTML or PHP files. Simply said this are the URL locations endpoints. The system automatically identify url-s file location by its build-in controller system. These pages can be located in modules, plugins and in the web folder.</p>
            <h4>There are some rules to be mentioned before jumping into examples:</h4>
            <p>- If filetype is specified in the url, the system will look for a file with the specified filetype.</p>
            <p>- If filetype is not specified in the url, the system will look for a file with filetype PHP automatically.</p>
            <p>- If file is placed in a folder with name of some user type, such as admin or other (even customly created) the system will make this folder secured and accessible only by the concrete user type.</p>
            <p>- For page files located in modules and plugins, module or plugin name must be placed in the start of the URL. The system will automatically resolve it.</p>
            
            <h5>Example for module page:</h5>
            <p>url: web.imasmi.com/Module_name/add</p>
            <p>file location: system/module/Module_name/page/add.php</p>
            
            <h5>Example for plugin page: </h5>
            <p>url: web.imasmi.com/Plugin_name/add.html</p>
            <p>file location: plugin/Plugin_name/page/add.html</p>
            
            <h5>Example for web page:</h5>
            <p>url: web.imasmi.com/admin/add</p>
            <p>file location: web/admin/add.php (and will be only accessible if user of type admin is logged in the system)</p>
        </li>
        <li>
            <h4>query</h4>
            <p>This folder is almost identical to page folder and is also used to store user-landing pages in the system such as HTML or PHP files.</p>
            <h4>Everything that applies to page folder applies to query folder with one main difference: when query page url is visited, it is fetched as it is, without ImaSmi Web surrounding system and theme output. Query pages are used to process database information, AJAX request returns and other specific operations.</h4>
            
            <h4>There are some rules to be mentioned before jumping into examples:</h4>
            <p>- If filetype is specified in the url, the system will look for a file with the specified filetype.</p>
            <p>- If filetype is not specified in the url, the system will look for a file with filetype PHP automatically.</p>
            <p>- If file is placed in a folder with name of some user type, such as admin or other (even customly created) the system will make this folder secured and accessible only by the concrete user type.</p>
            <p>- For page files located in modules and plugins, module or plugin name must be placed in the start of the URL. The system will automatically resolve it.</p>
            <p>- To open a query page, you must add the word query in the url after module or plugin name, or in the start of the url for web folder.</p>
            <p>- All php system, module, plugin and web files are auto-included and can be used in query pages.</p>
            
            <h5>Example for module page:</h5>
            <p>url: web.imasmi.com/Module_name/query/add</p>
            <p>file location: system/module/Module_name/query/page/add.php</p>
            
            <h5>Example for plugin page: </h5>
            <p>url: web.imasmi.com/Plugin_name/query/add.html</p>
            <p>file location: plugin/Plugin_name/page/query/add.html</p>
            
            <h5>Example for web page:</h5>
            <p>url: web.imasmi.com/query/admin/add</p>
            <p>file location: web/query/admin/add.php (and will be only accessible if user of type admin is logged in the system)</p>
        </li>
    </ul>

<h3>Files</h3>
    <ul>
        <li>
            <h4>top.php</h4>
            <p>This file will be auto-included before html output of the page. Here you can set variables, cookies and other information before html headers.</p>
        </li>
        <li>
            <h4>head.php</h4>
            <p>This file will be auto-included in the head html tag. Here you can set title, favicon and other head specific html items. You can also include stylesheets and javascript codes here.</p>
        </li>
        <li>
            <h4>header.php</h4>
            <p>This file will be auto-included right after the body html tag. Everything you place here will be wrapped in div with id #header. Here you can place your header specific items such as logo, menu and others.</p>
        </li>
        <li>
            <h4>index.php</h4>
            <p>This file will be auto-included in the body html tag after header content. Everything you place here will be wrapped in div with id #index and it's content will be globally available after the opened page or query url location content.</p>
        </li>
        <li>
            <h4>footer.php</h4>
            <p>This file will be auto-included right at the end of the body html tag after index content. Everything you place here will be wrapped in div with id #footer. Here you can place your footer specific items such as logo, footer menu, contacts and others.</p>
        </li>
    </ul>

<h3>Custom files and folders</h3>
    <div>Custom files and folders can be added in modules, plugins and web folder for creating a custom application structures.</div>
    <div>These files and folders won't be auto-included and must be integrated manually in the application.</div>
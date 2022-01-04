<h1>Web</h1>
    <span>Location: /web</span>
    <span>Web is the folder to store the application theme code.</span>
    <span>In the /web/file directories are saved all files by the File module by default.</span>
    <span>In the /web/ini are placed some INI files to set the current system enviorment (database.ini, plugin.ini, language.ini and others). These INI files are auto created and managed by the system upon varios events. So the number and the content of the files varies also based on the configuration ot the system and installed plugins.</span>
    <p class="manual-hint">Web is actually like any individual module or plugin with a special purpose to contain the current installed theme code.</p>
    <span>Web folder follows the <a class="manual-link" onclick="view('structure');">structure</a> model pattern.</span>
    <p class="manual-hint">In /web/head.php is recommended to place the $Page->head() function to have the default system head functionality.</p>
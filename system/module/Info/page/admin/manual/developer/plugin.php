<h1>Plugin</h1>
    <span>Location: /plugin</span>
    <span>The plugin folder contains all the custom plugins. Every plugin is a separate application with own purposes. Custom plugins can be created for all purposes and uses.</span>
    <p class="manual-hint">Plugins can be switched on and off from the GUI admin panel of the system or manually from /web/ini/plugin.ini (Example to switch on plugin: Contact = 1). Only switched on plugins will be connected to the system.</p>
    <span>Every plugin is separate application, which follows the <a class="manual-link" onclick="view('structure');">structure</a> model pattern. The model pattern autoinclusion of files is applied only for switched on plugins.</span>
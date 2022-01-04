<h1>SettingAPP.php</h1>
    <span>Useful functions for automated setting updates.</span>
    <span>SettingAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Setting/php/SettingAPP.php</span>
    <span>Namespace: system\module\Setting\php</span>
    <span>Instance: new \module\Setting\SettingAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>
    <span>SettingAPP extends the Setting class from the same namespace.</span>
    
    <h2>Functions</h2>
        <h3>SettingAPP->set_fields</h3>
            <span>Return array with tags for settings to be selected for update.</span>
            <span>Clears the language endings from the tags.</span>
            <span>Removes page_id and link_id if presented.</span>
            <span>Usually used directly with the $_POST variable.</span>
            <ul>
                <li>
                    <h4>SettingAPP->set_fields(array)</h4>
                    <p>Example: $SettingAPP->set_fields($_POST)</p>
                    <span>Example output for $_POST = array("page_id" => 4, "link_id" => "7","shop" => "", "shop_en" => "online", "shop_bg" => "интернет", "payment" => "", "payment_en" => "cash", "payment_bg" => "брой"): array("shop", "payment")</span>
                </li>
            </ul>
            
        <h3>SettingAPP->set</h3>
            <span>Create HTML INPUT updater for setting row.</span>
            <span>Needs a HTML FORM element wrapper.</span>
            <ul>
                <li>
                    <h4>SettingAPP->set(tag, array=array("column" => '*', "page_id" => 0, "link_id" => 0, "type" => "text", "required" => false))</h4>
                    <span>tag: the tag to select setting record from the database.</span>
                    <span>array:</span>
                        <ul>
                            <li>column (string): possible values are *|value|language. If set to * creates updater for value and languages field of the setting. If set to value creates updater for value field and if set to language, creates updaters for all system languages fields. If not set and default value is *.</li>
                            <li>page_id (integer): set page_id for the setting to select. If not set and default value is 0.</li>
                            <li>link_id (integer): set link_id for the setting to select. If not set and default value is 0.</li>
                            <li>type (string): HTML INPUT element type or textarea element. Possible values are text|textarea|checkbox|radio|number.</li>
                            <li>required (boolean): set to true to make HTML elements required in the form.</li>
                        </ul>
                    <p>Example: $SettingAPP->set("About", array("column" => "language", "page_id" => 4, "type"=>"text", "required" => true))</p>
                    <span>Will create a required input type="text" setting updater for setting with tag=About AND page_id=4.</span>
                </li>
            </ul>
            
        <h3>SettingAPP->save</h3>
            <span>Save settings received from HTML form created with SettingAPP->set elements or from customly created array.</span>
            <span>Usually used directly with the $_POST variable.</span>
            <span>Field without language ending (field_en) sets/update value column in setting table.</span>
            <span>Can't contain blank space in the field name.</span>
            <span>The settings are selected based on the field name without language ending used as tag. If the field name is about_en, the function will search for setting with tag=about.</span>
            <ul>
                <li>
                    <h4>SettingAPP->save(array)</h4>
                    <span>array:</span>
                        <ul>
                            <li>page_id (integer): set page_id for the setting to select. If not set and default value is $this->page_id.</li>
                            <li>link_id (integer): set link_id for the setting to select. If not set and default value is 0.</li>
                            <li>custom field to update: multiple elements to update in the settings database table. Example: "name" => "ImaSmi", "name_en" => "ImaSmi english", "name_bg" => "ИмаСми български"</li>
                        </ul>
                    <p>Example: $SettingAPP->save("about" => "ImaSmi", "about_en" => "ImaSmi english", "about_bg" => "ИмаСми български")</p>
                    <span>Will check for setting row with tag=about. If the row exists, its values will be updated. Otherwise new row will be created with the passed values.</span>
                </li>
            </ul>
<h1>Form.php</h1>
    <span>Form class for helping creating some html form elements.</span>
    <span>$Form - variable with initialized isntance of the class is available to use.</span>
    <span>Location: system/php/Form.php</span>
    <h3>Form->validate</h3>
        <span>An array of predefined elements with key and value to alert to the user, that something in the form input is wrong. This function use S.highlight function to point the errors.</span>
        <ul>
            <li>
                <h4>Form->validate(errors=array()</h4>
                <p>Example: $Form->validate(array("#name" => "Fill name", "#email" => "Incorrect email address"));</p>
                <span>The example above show messages Fill name and Incorrect email address to the screen and will highlight elements with ids name and email in the form on the screen.</span>
            </li>
        </ul>
    <h3>Form->on_off</h3>
        <span>An on and off swither to chage input value.</span>
        <ul>
            <li>
                <h4>Form->on_off(name, value=0,input=true</h4>
                <span>name: name of the switcher and name of the input element if input parameter is set to true. Example: switch</span>
                <span>value (optional): the predefined value for the switcher. 0 is for off, 1 for on. Default is 0. Example: 1.</span>
                <span>input (optional): add input hidden element to be used as form post with name from the name parameter. Default is true. Example: false.</span>
                <p>Example: $Form->on_off("switch",1);</p>
                <span>The example above will output an on and off switcher with input hidden element with value 1. The switch will be in on position.</span>
            </li>
        </ul>
    <h3>Form->select</h3>
        <span>Output a form select element.</span>
        <ul>
            <li>
                <h4>Form->select(name, values=array(),options=array(select=>string, reuqired=>boolean, title=>string, addon=>string|boolean, onchange=>javascript code)</h4>
                <span>name: name of select element. Example: languages</span>
                <span>values: array of option values with keys and values. Example: array("en"=>"english", "bg"=>"bulgarian").</span>
                <span>options (optional): possible options for the selecotr.select: a string to match with values key to be selected. required: true for the selector to be required. title: title for the selector first value, dafault is SELECT. addon: input text field to add value not listed in the selector. A string can be used for addon description or true for auto generated description. onchange: javascript code to handle onchange function.</span>
                <p>Example: $Form->select("languages",array("en"=>"english", "bg"=>"bulgarian"), array("select"=>"en", "required"=>true, "title"=>"Choose language", "addon"=>"add new language", "onchange"=>"alert('Language is changed')"));</p>
                <span>The example above will output select form element with name language and two options with keys en and bg and values english and bulgarian. The selected option will be english. The element will be required. Title of the first option will be Choose language. There will be input field to add new option, that is not in the selector. On change of the selected option the browser will alert message - Language is changed.</span>
            </li>
        </ul>
    <h3>Form->created</h3>
        <span>Output two form input elements. One of type date and one of type time.</span>
        <ul>
            <li>
                <h4>Form->created(name, value="0000-00-00 00:00:00")</h4>
                <span>name: name of the elements. The date element will output the name name_date. The time element will ouput name name_time. Example: created</span>
                <span>value (optional): set the date and the time in created format. Example: 2021-01-13 22:16:59.</span>
                <p>Example: $Form->created("created",2021-01-13 22:16:59);</p>
                <span>The example above will output one date input element with name created_date and value 2021-01-13 and one time input element with name created_time and value 22:16:59.</span>
            </li>
        </ul>
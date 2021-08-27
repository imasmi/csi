<h1>TextAPP.php</h1>
    <span>Text administration module.</span>
    <span>TextAPP.php is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Text/php/TextAPP.php</span>
    <span>Namespace: system\module\Text\php</span>
    <span>Instance: new \system\module\Text\php\TextAPP;</span>
    <span>Instance of the class must be initialized where is needed. No auto defined instance is available for use.</span>
    <span>TextAPP extends the Text class from the same namespace.</span>
    
    <h2>Functions</h2>
        <h3>TextAPP->wysiwyg</h3>
            <span>What you  see is what you get (wysiwyg) text editor panel.</span>
            <span>Instance of the function is auto included in /system/module/Text/index.php when admin is logged.</span>
            <ul>
                <li>
                    <h4>TextAPP->wysiwyg()</h4>
                    <p>Example: $TextAPP->wysiwyg()</p>
                    <span>Adds wysiwyg text editor to the application.</span>
                </li>
            </ul>
            
        <h3>TextAPP->color_picker</h3>
            <span>Color selector for texts and texts background colors.</span>
            
        <h3>TextAPP->slice</h3>
            <span>Return part of text, sliced by words.</span>
            <ul>
                <li>
                    <h4>TextAPP->slice(text, array=array())</h4>
                    <span>text (string): the string to be sliced.</span>
                    <span>array:</span>
                        <ul>
                            <li>start (int): a word number to start the slice. Default is 0 for the start of the text.</li>
                            <li>length (int): length of the slice.</li>
                            <li>search (string): a word to be searched for. If set the first founded word become a start point for the cut.</li>
                        </ul>
                    <p>Example: $TextAPP->slice("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.", array("search" => "dummy", "start" => -2, "length" => 5))</p>
                    <span>Example output: is simply dummy text of</span>
                </li>
            </ul>
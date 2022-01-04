<h1>CodeAPP.js</h1>
    <span>CodeAPP.js is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/Code/js/CodeAPP.js</span>
<h3>CodeAPP.cssSelector</h3>
    <span>Create css selector path from all item parent ids and the item id itself.</span>
    <ul>
        <li>
            <h4>CodeAPP.cssSelector(DOM element)</h4>
            <p>Example: CodeAPP.cssSelector(S("#custom-element"))</p>
            <span>Will create the following css path for element with parents ids index and after that theme: #index #theme #custom-element.</span>
        </li>
    </ul>
<h3>CodeAPP.cssEdit</h3>
    <span>Edit CSS styles for specified HTML DOM element.</span>
    <span>/web/css/custom.css - the location where CSS styles are edited. If file doesn't exists, it will be created automatically. This file is auto-included by default and all styles in it will be applied to the document automatically.</span>
    <span>Styles are parsed as JSON object ot the function with style names as keys and style values as values.</span>
    <ul>
        <li>
            <h4>CodeAPP.cssEdit(DOM element, JSON object)</h4>
            <p>Example: CodeAPP.cssEdit(S("#custom-element"), {width: "20px", position: "relative"})</p>
            <span>Will apply the following css rule in file /web/css/custom.css for element with parents ids index and after that theme: #index #theme #custom-element{width: 20px; position: relative;}</span>
            <span>If the style selector rule doesn't exists it will be created. If exists, it will be edited. Only applied properties will be edited, other rules won't be changed.</span>
        </li>
    </ul>
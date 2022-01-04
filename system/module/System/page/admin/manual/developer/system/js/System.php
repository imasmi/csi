<h1>System.js</h1>
    <span>System.js is JavaScipt library for handling common user-side operations build upon ES5 standart.</span>
    <span>It contains only one object attached to variable named S, which is querySelector return type function to select DOM elements.</span>
    <span>S variable has also some methods attached to it, for performing various operations.</span>
    <span>Location: system/js/System.js</span>
<h3>S</h3>
    <span>QuerySelector for DOM elements.</span>
    <ul>
        <li>
            <h4>S(DOM element selectors)</h4>
            <p>Example: S("#element").style.color = "red";</p>
            <span>The example above will set to the first HTML element with id element color to red.</span>
        </li>
    </ul>
<h3>S.all</h3>
    <span>QuerySelectorAll for DOM elements.</span>
    <span>Select all DOM elements with specified selectors and allows to be used in a list function.</span>
    <ul>
        <li>
            <h4>S.all(DOM element selectors, function(single element variable){})</h4>
            <p>Example: S.all(".element", function(el){ el.style.color = "red";});</p>
            <span>The example above will set to all HTML elements with class element colors to red.</span>
        </li>
    </ul>
<h3>S.url</h3>
    <span>Get current url.</span>
    <ul>
        <li>
            <h4>S.url()</h4>
            <p>Example: alert(S.url());</p>
            <span>The example above will output in alert message the current url of the page.</span>
        </li>
    </ul>
<h3>S.urlChange</h3>
    <span>Changes url and title if provided.</span>
    <ul>
        <li>
            <h4>S.urlChange(url, title=false)</h4>
            <p>Example: S.urlChange('/User/login', "Login Page");</p>
            <span>The example above will set to url to /User/login and title of the page to Login Page.</span>
        </li>
    </ul>
<h3>S.serialize</h3>
    <span>Output HTML form into JavaScript object.</span>
    <ul>
        <li>
            <h4>S.serialize(form element selectors)</h4>
            <p>Example: console.log(S.serialize("#form"));</p>
            <span>The example above will output to console HTML form as JavaScript object with form fields names as keys and form fields values as object values.</span>
        </li>
    </ul>
<h3>S.jsonToURL</h3>
    <span>Coverts JSON array to url with get parameters.</span>
    <ul>
        <li>
            <h4>S.jsonToURL(json object)</h4>
            <p>Example: S.urlChange('?' + S.jsonToURL({page : 'manual', section : 'javascript'}), 'JavaScript.js');</p>
            <span>The example above will set url get parameters to ?page=manual&section=javascript and title to JavaScript.js.</span>
        </li>
    </ul>
<h3>S.scriptExec</h3>
    <span>Finds script tags in string input and executes them as JavaScript.</span>
    <span>This is support function to find and execute script elements in AJAX responses.</span>
    <ul>
        <li>
            <h4>S.scriptExec(string)</h4>
            <p>Example: var data = "&lt;script&gt;alert('Hello world')&lt;/script&gt;"; S.scriptExec(data);</p>
            <span>The example above will execute string in the data variable and will output an alert Hello world message.</span>
        </li>
    </ul>
<h3>S.post</h3>
    <span>XML Http post request to fetch urls dinamically.</span>
    <span>It uses post method with JSON object for input parameters.</span>
    <ul>
        <li>
            <h4>S.post(url, json={}, output=false, silent=false)</h4>
            <span>url: url location to be fetched. Example: https://web.imasmi.com/system/manual/developer.php#system-js-system</span>
            <span>json (optional): JSON object with key and values. Example: {name='Peter', age='18'}</span>
            <span>output (optional) option 1: as DOM element selector to output the response in it. Exaple: '#response'</span>
            <span>output (optional) option 2: as function for further responce processing. Example: function(data){console.log(data);}</span>
            <span>silent (optional): if set to true, the default ImaSmi Web animated loader will not show.</span>
            <p>Example: S.post('/query/add-user');</p>
            <span>The example above will fetch url /query/add-user without sending any post data and will not receive any response.</span>
            <p>Example: S.post('/query/add-user', {name='Peter', age='18'});</p>
            <span>The example above will fetch url /query/add-user and will send post data name=Peter and age=18 and will not receive any response.</span>
            <p>Example: S.post('/query/add-user', {name='Peter', age='18'}, '#add-user-output');</p>
            <span>The example above will fetch url /query/add-user and will send post data name=Peter and age=18 and will ouput the received response in HTML element with an id add-user-output.</span>
            <p>Example: S.post('/query/add-user', {name='Peter', age='18'}, function(data){console.log(data);});</p>
            <span>The example above will fetch url /query/add-user and will send post data name=Peter and age=18 and will ouput the received response in the console.</span>
            <p>Example: S.post('/query/add-user', {name='Peter', age='18'}, '#add-user-output', false);</p>
            <span>The example above will fetch url /query/add-user and will send post data name=Peter and age=18 and will ouput the received response in HTML element with an id add-user-output. This operation will perform in silent mode and ImaSmi Web animated loader will not show to indicate it.</span>
        </li>
    </ul>
<h3>S.classAdd</h3>
    <span>Add one or more classes to elements</span>
    <ul>
        <li>
            <h4>S.classAdd(elements selector, classList){</h4>
            <p>Example: S.classAdd(".group", "active selected");</p>
            <span>The example above will add classes active and selected to all elements with class group.</span>
        </li>
    </ul>
<h3>S.classRemove</h3>
    <span>Remove one or more classes from elements</span>
    <ul>
        <li>
            <h4>S.classRemove(elements selector, classList){</h4>
            <p>Example: S.classRemove(".group", "active selected");</p>
            <span>The example above will remove classes active and selected from all elements with class group.</span>
        </li>
    </ul>
<h3>S.trim</h3>
    <span>Remove white spaces from string</span>
    <ul>
        <li>
            <h4>S.trim(string){</h4>
            <p>Example: console.log(S.string(" Hello world "));</p>
            <span>The example above will output to console Helloworld.</span>
        </li>
    </ul>
<h3>S.highlight</h3>
    <span>Highlights an element with red color border.</span>
    <ul>
        <li>
            <h4>S.highlight(element selector)</h4>
            <p>Example: S.highlight("#form-input");</p>
            <span>The example above will highlight a element with id form-input with border in red color.</span>
        </li>
    </ul>
<h3>S.inRange</h3>
    <span>Check if integer is in range between one and maximum value.</span>
    <span>If check integer is bigger than maximu, it  returns one.</span>
    <span>If check integer is zero, it  returns maximum.</span>
    <span>This function is useful for rotating sliders, changing gallery images and others.</span>
    <ul>
        <li>
            <h4>S.inRange(integer to check, maximum integer)</h4>
            <p>Example: S.inRange(4, 5)</p>
            <span>The example above will return 4.</span>
            <p>Example: S.inRange(6, 5)</p>
            <span>The example above will return 1.</span>
            <p>Example: S.inRange(0, 5)</p>
            <span>The example above will return 5.</span>
        </li>
    </ul>
<h3>S.show</h3>
    <span>Display selected elements.</span>
    <ul>
        <li>
            <h4>S.show(elements selector)</h4>
            <p>Example: S.show(".active");</p>
            <span>The example above will display all elements with class active.</span>
        </li>
    </ul>
<h3>S.hide</h3>
    <span>Hide selected elements.</span>
    <ul>
        <li>
            <h4>S.hide(elements selector)</h4>
            <p>Example: S.show(".inactive");</p>
            <span>The example above will hide all elements with class inactive.</span>
        </li>
    </ul>
<h3>S.toggle</h3>
    <span>Toggle between hide and show for selected elements</span>
    <ul>
        <li>
            <h4>S.toggle(elements selector)</h4>
            <p>Example: S.toggle(".active");</p>
            <span>The example above will hide all visible elements with class active and will display all hidden elements with the same class.</span>
        </li>
    </ul>
<h3>S.css</h3>
    <span>Append style sheets (css) to the document.</span>
    <ul>
        <li>
            <h4>S.css(string containing css)</h4>
            <p>Example: S.css(".active{display: block;} .inactive{display: none;}");</p>
            <span>The example above will append two css rules to the document. One for elements with class active and other for elements with class inactive.</span>
        </li>
    </ul>
<h3>S.remove</h3>
    <span>Remove selected element from the DOM.</span>
    <ul>
        <li>
            <h4>S.remove(element selector)</h4>
            <p>Example: S.remove("#remove-element");</p>
            <span>The example above will remove element with id remove-element from the HTML DOM.</span>
        </li>
    </ul>
<h3>S.info</h3>
    <span>Display an info message to the screen.</span>
    <ul>
        <li>
            <h4>S.info(string message)</h4>
            <p>Example: S.info("Hello ImaSmi Web");</p>
            <span>The example above display to the screen a message with text - Hello ImaSmi Web.</span>
        </li>
    </ul>
<h3>S.popup</h3>
    <span>Popup window for url response fetched with S.post function.</span>
    <ul>
        <li>
            <h4>S.popup(url, json={}, silent=false)</h4>
            <span>url: url location to be fetched. Example: https://web.imasmi.com/system/manual/developer.php#system-js-system</span>
            <span>json (optional): JSON object with key and values. Example: {name='Peter', age='18'}</span>
            <span>silent (optional): if set to true, the default ImaSmi Web animated loader will not show.</span>
            <p>Example: S.popup('/query/add-user');</p>
            <span>The example above will display window with fetched url respone from /query/add-user without sending any post data to the url.</span>
            <p>Example: S.popup('/query/add-user', {name='Peter', age='18'});</p>
            <span>The example above will display window with fetched url respone from /query/add-user and will send post data name=Peter and age=18 to the url.</span>
            <p>Example: S.popup('/query/add-user', {name='Peter', age='18'}, false);</p>
            <span>The example above will display window with fetched url respone from /query/add-user and will send post data name=Peter and age=18 to the url. This operation will perform in silent mode and ImaSmi Web animated loader will not show to indicate it.</span>
        </li>
    </ul>
<h3>S.popupExit</h3>
    <span>Destroy a popup window.</span>
    <ul>
        <li>
            <h4>S.popupExit()</h4>
            <p>Example: S.popupExit();</p>
            <span>The example above will remove any popup window from the screen.</span>
        </li>
    </ul>
<h3>S.checkAll</h3>
    <span>Select or unselect all selected checkboxes by leading HTML checkbox input.</span>
    <ul>
        <li>
            <h4>S.checkAll(leading element, elements selector)</h4>
            <p>Example: &lt;input type="checkbox" onchange="S.checkAll(this, '.active')"></p>
            <span>The example above will check all checkboxes with class active when the the leading checkbox is checked and will uncheck the same checkboxes when the leading checkbox is unchecked.</span>
        </li>
    </ul>
<h3>S.visible</h3>
    <span>Checks if selected element is currently visible on the screen.</span>
    <ul>
        <li>
            <h4>S.visible(elements selector)</h4>
            <p>Example: S.visible("#active");</p>
            <span>The example above will return true if element with id active is currently on the scrreen and false if it is not.</span>
        </li>
    </ul>
<h3>S.bind</h3>
    <span>Attach event listeners to specified element.</span>
    <ul>
        <li>
            <h4>S.bind(function, actions = "load,resize,scroll", elem=window)</h4>
            <span>function: a function to attach to the listeners. Example: function(){console.log('Event listener is attached.');}</span>
            <span>actions (optional): one or more event handlers to attach to the element. Default values are load,resize and scroll. Example: "click,change"</span>
            <span>elem (optional): an element to attach event listeners to. Default is window. Example: S("#listener")</span>
            <p>Example: S.bind(function(){ console.log("The document was loaded, resized or scrolled.");});</p>
            <span>The example above will attach event listeners for load, resize and scroll to the widnow object and if any of the listeners is fired, the filed function will execute.</span>
            <p>Example: S.bind(function(){ console.log("The document was loaded.");}, "load");</p>
            <span>The example above will attach event listener for load to the widnow object and when the window is loaded, the filed function will execute.</span>
            <p>Example: S.bind(function(el){ console.log(el.value);}, "click,change", S("#checkbox"));</p>
            <span>The example above will attach event listeners for click and change to element with id checkbox and when this element is clicked or changed, the filed function will execute.</span>
        </li>
    </ul>
<h3>S.animate</h3>
    <span>Automatically add class for animation purposes to all visible elements based on selector.</span>
    <ul>
        <li>
            <h4>S.animate(check_elem=".animation", add_class="animate")</h4>
            <span>check_elem (optional): a selector for animation elements. Default is elements with class animation. Example: ".animation"</span>
            <span>add_class (optional): class to be added to the currently visible animation elements. Default class id animate. Example: "animate"</span>
            <p>Example: S.bind(function(){ S.animate();});</p>
            <span>The example above will add class animate to all curently visible elements with class animation when the window is loaded, resized or scrolled.</span>
            <p>Example: S.bind(function(){ S.animate(".graphic", "alive");}, "load");</p>
            <span>The example above will add class alive to all curently visible elements with class graphic when the window is loaded.</span>
        </li>
    </ul>
<h3>S.slideTo</h3>
    <span>Function to scroll the screen to specified element. Default behavior is to sldie smooth to the element.</span>
    <ul>
        <li>
            <h4>S.slideTo(element = "#index", behave = "auto | smooth")</h4>
            <span>element (optional): an element to slide to. Default is the element with id index. Example: "#active"</span>
            <span>behave (optional): slide bahavior. Auto - scrolls instantly. Smooth - slide smoothly. Default is smooth. Example: "auto"</span>
            <p>Example: S.slideTo();</p>
            <span>The example above will scroll the window to element with id index in smooth fashion.</span>
            <p>Example: S.slideTo("#active", "auto");</p>
            <span>The example above will instantly scroll the window to element with id active.</span>
        </li>
    </ul>
<h3>S.computed</h3>
    <span>Get all computed css styles of element or value of single style if specified.</span>
    <ul>
        <li>
            <h4>S.computed(element, property=false)</h4>
            <span>element: an element to get styles. Example: "#active"</span>
            <span>property (optional): if specified, computed function will only the value of the property. Example: "height"</span>
            <p>Example: S.computed("#active");</p>
            <span>Will return all computed css styles of an element with id active.</span>
            <p>Example: S.computed("#active", "height");</p>
            <span>Will return value of the css style height of an element with id active.</span>
        </li>
    </ul>
<h3>S.parallax</h3>
    <span>Crete parallax scrolling effect for HTML element</span>
    <ul>
        <li>
            <h4>S.parallax(element, JSON object{direction(top|left):speed(window scrolling speed miltiplied)})</h4>
            <p>Example: S.parallax("#parallax", {top:3});</p>
            <span>Will create parallax scrolling efect for element with id parallax. As the window scrolls the element will go in the reverse top position with speed three times the scrolling speed.</span>
        </li>
    </ul>
<h3>S.galleryGetImages</h3>
    <span>Return JSON object with values from data-gallery-image for all elements with the specified value for the attribute data-gallery-category. A wrapper of the gallery with id #gallery- and the specified category is needed for this function to work properly.</span>
    <ul>
        <li>
            <h4>S.galleryGetImages(category selector)</h4>
            <p>Example: S.galleryGetImages("images");</p>
            <span>Will return JSON object with all values from data-gallery-image for all elements with value images for the attribute data-gallery-category.</span>
        </li>
    </ul>
<h3>S.gallery</h3>
    <span>Gallery preview with changer for all images specified in data-gallery-image attribures for all elements with the same value in data-gallery-category attribute.</span>
    <ul>
        <li>
            <h4>S.gallery(element=this)</h4>
            <p>Example: &lt;div data-gallery-image="/web/file/first.jpg" data-gallery-category="category-1" onclick="S.gallery()">&lt;img src="/web/file/first.jgp">&lt;/div></p>
            <span>When the element is clicked a gallery slider with all elements with data-gallery-category with value category-1 will show on the screen. Image sources will be those specified in data-gallery-image for each image.</span>
        </li>
    </ul>
<h3>S.offset</h3>
    <span>Get offset top and left position of element relativly to the scrolled pixels of the document.</span>
    <ul>
        <li>
            <h4>S.offset(element)</h4>
            <p>Example: var offset = S.offset("#active"); console.log(offset.top); console.log(S.offset("#active").left);</p>
            <span>Will output to the console top and left offset in pixels relatively to the scrolled pixels of the document.</span>
        </li>
    </ul>
<h3>S.parents</h3>
    <span>Return object with all parents of the element.</span>
    <ul>
        <li>
            <h4>S.parents(element)</h4>
            <p>Example: console.log(S.parents("#lower"));</p>
            <span>Will output to the console all parents to an element with id lower.</span>
        </li>
    </ul>
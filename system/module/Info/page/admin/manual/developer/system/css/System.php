<h1>System.css</h1>
    <span>System.css is ImaSmi Web main stylesheet library.</span>
    <span>It has a lot of built-in classes for layout display and saves a lot of work when building a custom user interface.</span>
    <span>Location: system/css/System.css</span>
<h2>Layout</h2>
    <span>There are two types of screen layout in ImaSmi Web. One is more flexible in its usage and is based on float left property and the other is based on the most recently added column-count property.</span>
<h3>Column</h3>
    <span>.column,.column-1,.column-2,.column-3,.column-4,.column-5,.column-6,.column-7,.column-8,.column-9,.column-10,.column-11,.column-12</span>
    <br/>
    <span>Columns are styles for layot control. They divide the screen into up to twelve equal parts. Columns use float left property, and each column is 8.33333333333% of the screen.</span>
    <ul>
        <li>
            <h4>All column share the same styles.</h4>
            <p>.column,.column-1,.column-2,.column-3,.column-4,.column-5,.column-6,.column-7,.column-8,.column-9,.column-10,.column-11,.column-12 {box-sizing: border-box; float: left; position: relative;}</p>
        </li>
        <li>
            <h4>Every column width is 8.33333333333% multiplied by the column number</h4>
            <p>.column-1{width: 8.33333333333%;} .column-2{width: 16.6666666667%;} .column-3{width: 25%;} .column-4{width: 33.3333333333%;} .column-5{width: 41.6666666667%;} .column-6{width: 50%;} .column-7{width: 58.3333333333%;} .column-8{width: 66.6666666667%;} .column-9{width: 75%;} .column-10{width: 83.3333333333%;} .column-11{width: 91.6666666667%;} .column-12{width: 100%;}</p>
        </li>
        <li>
            <h4>Example:</h4>
            <p>
                <div class="column-6">Element with class="column-6". Takes 50% of the parent screen space.</div>
                <div class="column-3">Element with class="column-3". Takes 25% of the parent screen space.</div>
                <div class="column-3">Element with class="column-3". Takes 25% of the parent screen space.</div>
            </p>
        </li>
    </ul>
<h3>Column in responsive layout</h3>
    <span>As deviding the screen in twelve parts is unreasonable in mobile devices, columns have some predefined values for responsive layout.</span>
    <ul>    
        <li>
            <h4>On devices with maximum screen width up to 1080px columns of all sizes occupy the entire screen and lose the float left property.</h4>
            <p>.column, .column-1, .column-2,.column-3,.column-4,.column-5,.column-6,.column-7,.column-8,.column-9,.column-10,.column-11,.column-12{width: 100%; float: none; display: block;}</p>
        </li>
    </ul>
<h3>Clear column space</h3>    
    <span>Floated elements doesn't occupy space in the normal document flow. As this behavior can cause inconvenience in some situations, a clear class can be used to restore the normal document flow around column elements.</span>
    <ul>
        <li>
            <h4>Clear class use clear both property and the the clearfix hack to restore normal document flow around column elements:</h4>
            <p>.clear{clear:both;} .clear:before,.clear:after {content: " "; display: table; clear: both;}</p>
        </li>
        <li>
            <h4>Column elements must be wrapped around by element with clear class:</h4>
            <p>
                &lt;div class="clear"&gt;<br/>
                &emsp;&lt;div class="column-6"&gt;&lt;/div&gt;<br/>
                &emsp;&lt;div class="column-6"&gt;&lt;/div&gt;<br/>
                &lt;/div&gt;
            </p>
        </li>
    </ul>
<h3>Column-count</h3>
    <span>.column-count-2, .column-count-3, .column-count-4, .column-count-5, .column-count-6, .column-count-7, .column-count-8</span>
    <span>Column-count elements are the other way to control layout in ImaSmi Web.</span>
    <span>They are pretty staightforward and devide the screen into up to eight equal parts, according the specified value.</span>
    <ul>
        <li>
            <h4>Column-count value devide its children elements to up to eight equal parts. The followin example will devide the screen to four equal parts.</h4>
            <p>
                &lt;div class="column-count-4"&gt;<br/>
                &emsp;&lt;div&gt;&lt;/div&gt;<br/>
                &emsp;&lt;div&gt;&lt;/div&gt;<br/>
                &emsp;&lt;div&gt;&lt;/div&gt;<br/>
                &emsp;&lt;div&gt;&lt;/div&gt;<br/>
                &lt;/div&gt;
            </p>
        </li>
    </ul>
<h3>Column-count in responsive layout</h3>
    <span>As deviding the screen in eight parts is unreasonable in mobile devices, column-count have some predefined values for responsive layout.</span>
    <ul>    
        <li>
            <h4>On devices with maximum screen width up to 1080px column-count children of all values occupy the entire screen.</h4>
            <p>.column-count-2, .column-count-3, .column-count-4, .column-count-5,.column-count-6, .column-count-7, .column-count-8{-ms-column-count:1;-moz-column-count:1;-webkit-column-count:1;column-count: 1;}</p>
        </li>
    </ul>
<h2>Menu</h2>
    <span>These are some predefined styles for Menu class in Page module</span>
    <p>
        .menu{background-color: inherit;}
        .menu ul{list-style-type: none;}<br/>
        .menu .links{width: 100%; margin: 0; padding: 0;}<br/>
        .menu .mobile-open, .menu .mobile-close{cursor: pointer; display: none; text-align: center;}<br/>
        .menu .menu-content{width: 100%; height: 100%; display: inline-block;}
    </p>
<h2>Text align</h2>
    <ul>
        <li>
            <h4>Left</h4>
            <p>.text-left{text-align:left;}</p>
        </li>
        <li>
            <h4>Center</h4>
            <p>.text-center{text-align:center;}</p>
        </li>
        <li>
            <h4>Right</h4>
            <p>.text-right{text-align:right;}</p>
        </li>
    </ul>
<h2>Float</h2>
    <ul>
        <li>
            <h4>Left</h4>
            <p>.left{float: left;}</p>
        </li>
        <li>
            <h4>Right</h4>
            <p>.right{float:right;}</p>
        </li>
    </ul>
<h2>Center</h2>
    <ul>
        <li>
            <h4>Center element horizontally</h4>
            <p>.center{margin-left: auto; margin-right: auto;}</p>
        </li>
        <li>
            <h4>Center element vertically</h4>
            <p>.middle{display: flex; justify-content: center; align-content: center; flex-direction: column;}</p>
        </li>
    </ul>
<h2>highlighting</h2>
    <ul>
        <li>
            <h4>Attention area</h4>
            <p>.attention{background-color: #f08080; text-align: center; padding: 15px 0; font-size: 24px; font-weight: bold;}</p>
        </li>
        <li>
            <h4>Success area</h4>
            <p>.success{background-color: #90ee90;}</p>
        </li>
        <li>
            <h4>Fail area</h4>
            <p>.fail{background-color: #f08080;}</p>
        </li>
    </ul>
<h2>Cursor</h2>
    <ul>
        <li>
            <h4>Pointer</h4>
            <p>.pointer{cursor: pointer;}</p>
        </li>
    </ul>
<h2>View</h2>
    <span>View wrapper for listing tables</span>
    <p>
        .view{margin: 50px auto;width:fit-content; font-family: sans-serif, arial; font-size: 16px; font-weight: normal;}<br/>
        .view td,.view th{padding:5px;border:0}
        .view input,.view select{padding:5px 10px;font-size:18px}
        .view select{width:100%;}
    </p>
<h2>On-off switcher</h2>
    <span>Style for on-off switcher to be used in Form system class on_off function or in custom applications.</span>
    <p>
        .on-off{width:60px;height:30px;position:relative;border-radius:15px;border:1px solid gray;line-height:30px;font-size:12px;text-align:center}<br/>
        .change-on-off{width:50%;display:block;height:100%;float:left;cursor:pointer}<br/>
        .on-off .switcher{position:absolute;width:50%;height:100%;transition:1s;border-radius:20px}<br/>
        .on-off .on{left:0;top:0;background-color:green}<br/>
        .on-off .off{left:50%;top:0;background-color:red}
    </p>
<h2>Button</h2>
    <ul>
        <li>
            <h4>Default button class on new installation</h4>
            <p>
                .button{outline:0;border:0;background-color:#08494c;color:#fff;padding:8px 16px;transition:.3s}<br/>
                .button:hover{cursor:pointer;background-color:#001f21}
            </p>
        </li>
    </ul> 
<h2>Fullscreen and background elements</h2>
    <ul>
        <li>
            <h4>Set elements to fullscreen according to parent element</h4>
            <p>.fullscreen{ width: 100%; height: 100%;}</p>
        </li>
        <li>
            <h4>Set posioioned absolute background in relative elements</h4>
            <p>.background{ width: 100%; height: 100%; position: absolute; top: 0; left: 0;}</p>
        </li>
    </ul> 
<h2>Info elements (popup, loading, info)</h2>
    <ul>
        <li>
            <h4>Popup and loading wrapper</h4>
            <p>.popup, #loading{ display: none; position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 999; text-align: center; overflow: auto;}</p>
        </li>
        <li>
            <h4>Close popup and loading clickable backgrounds</h4>
            <p>.close-popup, #loading .background{ position: fixed; width: 100%; height: 100%; background-color: #151515; opacity: 0.8;}</p>
        </li>
        <li>
            <h4>Info popup container</h4>
            <p>.popup-content{font-size: 20px; background-color: #ffffff; color: #000000; display: inline-block; padding: 50px; margin: 100px auto; position: relative;}</p>
        </li>
        <li>
            <h4>Loading animation style</h4>
            <p>#loading img{position: fixed; top: 50%; left: 50%; margin: -63px 0 0 -63px;}</p>
        </li>
        <li>
            <h4>Info element icon</h4>
            <p>.info{ display: inline-block; cursor: pointer; background-color: #6a0000; border-radius: 50%; padding: 2px 7px; color: #ffffff; font-weight: bold;}</p>
        </li>
    </ul>
    
<h2>Margin styles</h2>
    <span>ImaSmi Web has ten built-in styles for margin control from margin-10 to margin-100</span>
    <ul>
        <li>
            <h4>Margin control styles</h4>
            <p>
                .margin-10{margin: 10px;}<br/>.margin-20{margin: 20px;}<br/>.margin-30{margin: 30px;}<br/>.margin-40{margin: 40px;}<br/>.margin-50{margin: 50px;}<br/>
                .margin-60{margin: 60px;}<br/>.margin-70{margin: 70px;}<br/>.margin-80{margin: 80px;}<br/>.margin-90{margin: 90px;}<br/>.margin-100{margin: 100px;}
            </p>
        </li>
    </ul>
<h2>Padding styles</h2>
    <span>ImaSmi Web has ten built-in styles for padding control from padding-10 to padding-100</span>
    <ul>
        <li>
            <h4>Padding control styles</h4>
            <p>
                .padding-10{padding: 10px;}<br/>.padding-20{padding: 20px;}<br/>.padding-30{padding: 30px;}<br/>.padding-40{padding: 40px;}<br/>.padding-50{padding: 50px;}<br/>
                .padding-60{padding: 60px;}<br/>.padding-70{padding: 70px;}<br/>.padding-80{padding: 80px;}<br/>.padding-90{padding: 90px;}<br/>.padding-100{padding: 100px;}
            </p>
        </li>
    </ul>
<h2>Colors</h2>
    <ul>
        <li>
            <h4>White color styles for color and background</h4>
            <p>.white{color: #ffffff;}<br/>.white-bg{background-color: #ffffff;}</p>
        </li>
         <li>
            <h4>Black color styles for color and background</h4>
            <p>.black{color: #000000;}<br/>.black-bg{background-color: #000000;}</p>
        </li>
    </ul>
<h2>Box sizing</h2>
    <ul>
        <li>
            <h4>Box sizing style for elements total width and height with padding and width properties used together.</h4>
            <p>.border-box{box-sizing: border-box;}</p>
        </li>
    </ul>
<h2>Display styles</h2>
    <ul>
        <li>
            <h4>Show elements</h4>
            <p>.show{display: unset;}</p>
        </li>
        <li>
            <h4>Hide elements</h4>
            <p>.hide{display: none;}</p>
        </li>
        <li>
            <h4>Block display</h4>
            <p>.block{display: block;}</p>
        </li>
        <li>
            <h4>Inline display</h4>
            <p>.inline{display: inline;}</p>
        </li>
        <li>
            <h4>Inline block with vertiacal align top style</h4>
            <p>.inline-block{display: inline-block; vertical-align: top;}</p>
        </li>
        <li>
            <h4>Table display</h4>
            <p>.table{display: table;}</p>
        </li>
    </ul>
<h2>Position styles</h2>
    <ul>
        <li>
            <h4>Relative position</h4>
            <p>.relative{position: relative;}</p>
        </li>
        <li>
            <h4>Absolute position</h4>
            <p>.absolute{position: absolute;}</p>
        </li>
        <li>
            <h4>Fixed position</h4>
            <p>.fixed{position: fixed;}</p>
        </li>
    </ul>
<h2>File display styles</h2>
    <span>These styles are created for files display control. You can use them for HTML images and video attributes for easy customization.</span>
    <ul>
        <li>
            <h4>Set File module items, such as images and videos in fullscreen relative to the parent element. All File module items possess this class</h4>
            <p>.File{ width: 100%; height: 100%;}</p>
        </li>
        <li>
            <h4>Image default display class</h4>
            <p>.image{width: 300px; height: 300px; display: block; background-size:cover; object-fit: cover; background-position: center; background-repeat: no-repeat;}</p>
        </li>
        <li>
            <h4>Contain style to set images with background position and object-fit properties</h4>
            <p>.contain, .contain .image{background-size:contain; object-fit: contain;}</p>
        </li>
        <li>
            <h4>Fullscreen style for images and videos to fill parent relative element.</h4>
            <p>.background .image, .fullscreen, .fullscreen .image, .fullscreen-image .image, .fullscreen .video{ width: 100%; height: 100%;}</p>
        </li>
        <li>
            <h4>Empty files style, where image or video is not set yet</h4>
            <p>.file-empty .image{width: 150px; height: 150px;}</p>
        </li>
        <li>
            <h4>Video default display class</h4>
            <p>.video{height: 300px; width: 300px;}</p>
        </li>
        <li>
            <h4>Prevent image dragging class</h4>
            <p>.drag-none, .drag-none .image{-webkit-user-drag: none; -khtml-user-drag: none; -moz-user-drag: none; -o-user-drag: none; user-drag: none;}</p>
        </li>
    </ul>
<h2>Responsive</h2>
    <span>These responsive control display styles can be handy in building responsive mobile layouts.</span>
    <ul>
        <li>
            <h4>Desktop style to hide elements in mobile screens where maximum width is under 1080 pixels</h4>
            <p>@media only screen and (max-width: 1080px){.desktop{display: none;}}</p>
        </li>
    </ul>
    <ul>
        <li>
            <h4>Mobile style to hide elements in desktop mode and show them in mobile screens where maximum width is under 1080 pixels</h4>
            <p>.mobile{display: none;}</p>
            <p>@media only screen and (max-width: 1080px){.mobile{display: unset;}}</p>
        </li>
    </ul>
<h2>Full code:</h2>
<p>
<?php 
    $css = explode("\n", file_get_contents($Core->domain() . '/system/css/System.css'));
    foreach($css as $row){
    ?>
        <?php echo $row;?></br>
    <?php
    }
?>
</p>
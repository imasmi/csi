<h1>FileAPP.js</h1>
    <span>FileAPP.js is auto included only when user of type admin is logged in the system.</span>
    <span>Location: system/module/File/js/FileAPP.js</span>
    
    <h3>FileAPP.preload</h3>
        <span>Dynamically preview file from form file input at specified target location.</span>
        <ul>
            <li>
                <h4>FileAPP.preload(file, target)</h4>
                <p>Example: &lt;input type="file" onchange="FileAPP.preload(this.files[0], '#file-preview');"></p>
                <span>This example will preview the file at #file-preview location when the input value is changed.</span>
            </li>
        </ul>
        
    <h3>FileAPP.change</h3>
        <span>Supporting FileAPP->input php function to add multiple items at once. It hiddes the current file input to preserve loaded files to the moment and creates new file input to be able to load more files.</span>
        <ul>
            <li>
                <h4>FileAPP.change(files, id, array)</h4>
                <string>files: input type file this javascript object</string>
                <string>id: id of the current visible file input </string>
                <string>array: json_encode object of the array parsed in the FileAPP->input function. FileAPP->input array possible values - link_id(int), multiple(true), accept(filetypes), tag(text), languages(true)</string>
                <p>&lt;input type="file" name="echo $id . '_0'; if($multiple == 1){ echo '[]';}" class="background input-attribute" if($multiple == 1){ echo 'multiple';}
                onchange='FileAPP.change(this, " echo $id;",  echo json_encode($array);)' 
                accept="echo (isset($array["accept"])) ? $array["accept"] : $this->accept();"></p>
                <span>This example will add one or more files (if $array["multiple"] is set to true) to FileAPP->input when file input is updated. It will hide the current file input and will create new one to add more files.</span>
            </li>
        </ul>
        
    <h3>FileAPP.moveStart</h3>
        <span>Drag image onmousedown to change the center position.</span>
        <ul>
            <li>
                <h4>FileAPP.moveStart(event, id)</h4>
                <string>event: catch the event position of the element </string>
                <string>id: id of the element to reposition </string>
                <p>onmousedown="FileAPP.moveStart(event, id)"</p>
                <span>Start drag reposition of the image center until mouse left button is down.</span>
            </li>
        </ul>
        
    <h3>FileAPP.moveStop</h3>
        <span>Stop image reposition fired with FileAPP.moveStart when mouse leave the image cointainer or when mouse left button is up (this also triggers FileAPP.moveSafe function to safe image reposition).</span>
        <ul>
            <li>
                <h4>FileAPP.moveStop(id)</h4>
                <p>onmouseleave="FileAPP.moveStop(id)"</p>
                <span>Stop drag reposition of the image center to the current location.</span>
            </li>
        </ul>
        
    <h3>FileAPP.moveSafe</h3>
        <span>Save image reposition fired with FileAPP.moveStart when mouse left button is up.</span>
        <ul>
            <li>
                <h4>FileAPP.moveSafe(id)</h4>
                <p>onmouseup="FileAPP.moveSafe(id)"</p>
                <span>Save drag reposition of the image center at the current location.</span>
            </li>
        </ul>
        
    <h3>FileAPP.updateFile</h3>
        <span>Open image updater when image is double-clicked. Image updater is S.post request to /File/query/admin/update-file where FileAPP->input_edit function is placed.</span>
        <ul>
            <li>
                <h4>FileAPP.updateFile(id)</h4>
                <p>ondblclick="FileAPP.updateFile(id)"</p>
                <span>Open image updater popup.</span>
            </li>
        </ul>
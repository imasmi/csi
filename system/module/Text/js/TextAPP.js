var TextAPP = function(){};

/* WYSIWYG */

TextAPP.insertPaste = function(writePosition){
    range = window.getSelection().getRangeAt(0);
    range.insertNode(range.createContextualFragment((document.getElementsByName("paste-text")[0].checked === true ? S("#text-plain").innerHTML : S("#text-html").innerHTML )));
    S.popupExit();
    TextAPP.hideWysiwyg(event);
}

TextAPP.pasteText = function(event){
    event.preventDefault();
    var id = document.getElementById("selected-content").value;
    var elem = document.getElementById("text-edit-" + id);
    let textPlain = event.clipboardData.getData( 'text/plain' );
    let textHtml = event.clipboardData.getData( 'text/html' );
    
    let writePosition = elem.innerHTML.indexOf(window.getSelection().anchorNode.parentElement.innerHTML);
    let output = '<div class="popup-content select-none">';
    output += '<h2>Text paste</h2>';
    output += '<div class="hide" id="text-plain">' + textPlain + '</div>';
    output += '<div class="hide" id="text-html">' + textHtml + '</div>';
    output += '<div><input type="radio" name="paste-text" value="plain-text" checked> Paste as plain text (recommended)</div>';
    output += '<div><input type="radio" name="paste-text" value="html-text"> Paste with styles (the pasted content will be pasted with styles)</div>';
    output += '<div class="padding-20">';
        output += '<button class="button" type="button" onclick="TextAPP.insertPaste(' + writePosition + ')">Save</button>';
        output += '<button class="button" onclick="S.popupExit()">Close</button>';
    output += '</div>';
    output += '</div>';
    S.popup(output);
    return false;
}

TextAPP.showWysiwyg = function (event, id){
	setTimeout( function(){
		//if(document.getElementById("info").style.height != '' && document.getElementById("info").style.height != "0px"){ hide_info(event);}
//SHOW LANG EDITOR IF THERE IS MORE THAN ONE LANGUAGE
		if(document.getElementById("language-editor-" + id)){document.getElementById("language-editor-" + id).style.display = 'block';}
//BIND HIDE WYSIWYG FUNCTION IF IT IS NOT BINDED ALREADY TO THAT ELEMENT	
		document.getElementById("wysiwyg").style.display = 'block';
		document.getElementById("selected-content").value = id;
		document.addEventListener("mousedown", TextAPP.hideWysiwyg);
		document.getElementById("text-edit-" + id).addEventListener("paste", TextAPP.pasteText);
	},100);
}

TextAPP.hideWysiwyg = function (event){
		var id = document.getElementById("selected-content").value;
		var hide = true;
		for(a = 0; a < event.path.length; a++){
		    if(event.path[a].id == "text-edit-" + id || event.path[a].id == "wysiwyg" || event.path[a].className == "language-editor"){ hide = false;}
		}
		
        if(hide == true){
    //UPDATE TEXT AFTER LOOSING THE TEXT FIELD FOCUS
			TextAPP.updateText("close");
			document.getElementById("color-selector-backcolor").style.display = 'none';
			document.getElementById("color-selector-forecolor").style.display = 'none';
			document.getElementById("wysiwyg").style.display = 'none';
			document.getElementById("text-edit-" + id).removeEventListener("focus", TextAPP.pasteText);
			document.removeEventListener("mousedown", TextAPP.hideWysiwyg);
        }
}

//Drop images in wysiwyg area and save them as base64 string
S.bind(function() {
    var handleDrag = function(e) {
        //kill any default behavior
        e.stopPropagation();
        e.preventDefault();
    };
    var handleDrop = function(e) {
        //kill any default behavior
        e.stopPropagation();
        e.preventDefault();
        //console.log(e);
        //get x and y coordinates of the dropped item
        x = e.clientX;
        y = e.clientY;
        //drops are treated as multiple files. Only dealing with single files right now, so assume its the first object you're interested in
        var file = e.dataTransfer.files[0];
        //don't try to mess with non-image files
        if (file.type.match('image.*')) {
            //then we have an image,

            //we have a file handle, need to read it with file reader!
            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                //get the data uri
                var dataURI = theFile.target.result;
                //make a new image element with the dataURI as the source
                var img = document.createElement("img");
                img.src = dataURI;

                //Insert the image at the carat

                // Try the standards-based way first. This works in FF
                if (document.caretPositionFromPoint) {
                    var pos = document.caretPositionFromPoint(x, y);
                    range = document.createRange();
                    range.setStart(pos.offsetNode, pos.offset);
                    range.collapse();
                    range.insertNode(img);
                }
                // Next, the WebKit way. This works in Chrome.
                else if (document.caretRangeFromPoint) {
                    range = document.caretRangeFromPoint(x, y);
                    range.insertNode(img);
                }
                else
                {
                    //not supporting IE right now.
                    console.log('Not supported browser');
                }


            });
            //this reads in the file, and the onload event triggers, which adds the image to the div at the carat
            reader.readAsDataURL(file);
        }
    };

    S.all(".Text", function(el){
        el.addEventListener('dragover', handleDrag, false);
        el.addEventListener('drop', handleDrop, false);
    });
}, "load");

/* UPDATE TEXT ON BLUR */
TextAPP.updateText = function (close=false){
    id = document.getElementById("selected-content").value;
    val = document.getElementById("text-edit-" + id).innerHTML;
    lang = document.getElementById("text-lang-" + id).value;
    options = (document.getElementById("text-options-" + id)) ? document.getElementById("text-options-" + id).value : "{}";
	if(val != " " && val != "<br>" && val != null && val != "" && val != "\r\n" && val != "\n"){ content = String(val);} else { content = "";}
	
	optionsObject = JSON.parse(options);
	if(optionsObject["url"] && optionsObject["url"] == true){
	    S.post(S.url() + "Text/query/admin/update-text", { text: content, id: id, lang: lang, options: options}, function(data){
	        var output = JSON.parse(data);
	        S.urlChange(output.url, (output.Title) ? output.Title : false);
	        if(close == "close" && document.getElementById("language-editor-" + id)){
        		document.getElementById("language-editor-" + id).style.display = 'none';
    			TextAPP.langChange(id, document.getElementById("lang").value, "0");
            }
	    });
	} else {
	    S.post(S.url() + "Text/query/admin/update-text", { text: content, id: id, lang: lang, options: options}, function(data){
			//SET TEXT LANGUAGE TO CHOOSEN LANGUAGE AND RETURN CURRENT LANGUAGE DATA IN THE FIELD (ONLY IF SITE IS MULTILANGUAGE)
            if(close == "close" && document.getElementById("language-editor-" + id)){
        		document.getElementById("language-editor-" + id).style.display = 'none';
    			TextAPP.langChange(id, document.getElementById("lang").value, "0");
            }   
	    });
	}
}

TextAPP.langChange = function(id, lang, update=true){
    oldLang = document.getElementById("text-lang-" + id).value;
    document.getElementById("lang-changer-" + oldLang + '-' + id).style.backgroundColor = "unset";
    document.getElementById("lang-changer-" + lang + '-' + id).style.backgroundColor = "lightblue";
    
//UPDATE TEXT IF LANGUAGE IS CHANGED FOR CURRENT FIELD
//IF LOOSING FOCUS TEXT FIELD LANGUAGE WILL BE UPDATED IN HIDE WYSIWYG FUNCTION, NOT HERE
    if(update == "1"){TextAPP.updateText();}
    
    document.getElementById("text-lang-" + id).value = lang;
    
    S.post(S.url() + 'Text/query/admin/lang-change', {'id': id, 'lang': lang}, '#text-edit-' +  id);
    if(update == true){document.getElementById("text-edit-" + id).focus();}
}

/* WYSIWYG */

TextAPP.wysiwyg = function(com,val=false){
	if(val === "" || val === null){return false;}
	// check if justify option: if img is selected change float, otherwise change text-align
	if(com.indexOf('justify') !== -1){
        var sel = window.getSelection();
        var selEl = sel.anchorNode.childNodes[sel.anchorOffset];
        if(selEl !== undefined && selEl.nodeName == "IMG"){
            switch(com){
                case 'justifyleft':
                selEl.style.float = 'left';
                break;
                case 'justifyright':
                selEl.style.float = 'right';
                break;
                default:
                selEl.style.float = 'none';
            }
        } else {
            document.execCommand(com,false,val);
        }
    } else {
        document.execCommand(com,false,val);
    }
}

/* COLOR SELECTOR */

TextAPP.selectColor = function(id, cnt, type=false){
	if(type == "wysiwyg"){
		document.execCommand(id, false, document.getElementById("colorField" + cnt).value);
	} else{
		document.getElementById("settings-color" + id).style.backgroundColor = document.getElementById("colorField" + cnt).value;
		document.getElementById("color-val-" + id).value = document.getElementById("colorField" + cnt).value;
	}
	document.getElementById("color-selector-" + id).style.display = "none";
}
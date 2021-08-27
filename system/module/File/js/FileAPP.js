var FileAPP = function(){};

FileAPP.preload = function(file, target){
    var fileReader = new FileReader();
    if(file.type.match('image')) {
		fileReader.onload = function(e) {
		    S(target).innerHTML = '<div class="image" style="background-image: url(' + e.target.result + ')"></div>';
		};
		fileReader.readAsDataURL(file);
	}
	
	if(file.type.match('video')){
		fileReader.onload = function(e) {
		var blob = new Blob([e.target.result], {type: file.type});
		var url = URL.createObjectURL(blob);
		var video = document.createElement('video');
		var timeupdate = function() {
			if (snapImage()) {
				video.removeEventListener('timeupdate', timeupdate);
				video.pause();
			}
		};
		video.addEventListener('loadeddata', function() {
			if (snapImage()) {
				video.removeEventListener('timeupdate', timeupdate);
			}
		});
		var snapImage = function() {
       		var canvas = document.createElement('canvas');
       		canvas.width = video.videoWidth;
        	canvas.height = video.videoHeight;
        	canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        	var image = canvas.toDataURL();
       	 	var success = image.length > 100000;
       	 	if (success) {
			    S(target).innerHTML = '<div class="video" style="background-image: url(' + image + ')"></div>';
				URL.revokeObjectURL(url);
			}
        	return success;
		};
		video.addEventListener('timeupdate', timeupdate);
		video.preload = 'metadata';
		video.src = url;
		// Load video in Safari / IE11
		video.muted = true;
		video.playsInline = true;
		video.play();
		};
		fileReader.readAsArrayBuffer(file);
	}  

	if(file.type.match('audio')) {
		S(target).innerHTML = '<div class="title">' + file.name + '</div>';
	}
	
	if(file.type.match('application') || file.type.match('text')){
	    S(target).innerHTML = '<div class="title">' + file.name + '</div>';
	}
}

FileAPP.change = function(el, id, arr){
    preview = "preload_" + id;
    var firstId = id; //Original first id
    var last_input = S("#input-" + id + " #last_input_" + id); // Select last_input_id to use
    id = firstId + "_" + Number(last_input.value); //Set new working id with the last input used
    
    //This code make it possible to add more files in multiple regime
    if(arr["multiple"]){
        
        var input = document.createElement("div"); //Create new input element 
        input.setAttribute('class', 'file-upload relative');
        S.hide("#input-" + firstId + " #" + id  + "_loader"); //Hide used file input
        last_input.value = Number(last_input.value) + 1; //Count up last_input_id
        var nextId = firstId + "_" + last_input.value; //Set id for next file input form field
        input.setAttribute('id', nextId + "_loader"); //Set id to the new file input
        input.innerHTML = S("#input-" + firstId + " #" + firstId + "_0_loader").innerHTML; //Load input fields, first elsment is used as template
        S("#input-" + firstId + " .input-elements").appendChild(input); //Place the new file input
        input.querySelector(".input-attribute").setAttribute('name', nextId + "[]"); //Add new name to the new file input
        S("#last_loaded_" + firstId).value = 0; //Reset the file counter for the new input
    }
    
    
    for(var i = 0; i < el.files.length; i++){
        S.post(S.url() + "File/query/input-form?id=" + firstId + "&path=" + (id + "_" + i), arr, function(data){
            // Create new element to place in file previewer
            var output = document.createElement("div");
            output.setAttribute('class', 'relative');
            output.innerHTML = data;
            var path = output.querySelector(".path").value;
            output.setAttribute('id', path);
            
            // Append new elements if multiple input, or clean the form and place new file for single input
            if(arr["multiple"]){
    	        S("#preload_" + firstId).appendChild(output);
            } else {
                S("#preload_" + firstId).innerHTML = "";
                S("#preload_" + firstId).appendChild(output);
            }
            
            var file = el.files[path.split("_")[2]];
            var fileName = file.name.split('.').slice(0, -1).join('.');
            
            document.getElementById(path + "_origin").value = file.name;
            document.getElementById(path + "_name").value = fileName;
            document.getElementById(path + "_filetype").innerHTML = file.type;
            
            FileAPP.preload(file, '#' +  path + '_preload');
        });
    }
}

var FileReposition;
var moveStop = false;

FileAPP.moveStart = function(event, id){
    elem = S("#file" + id);
    
    elem.style.cursor = "grab";
    var offset = S.offset("#file" + id);
    img = elem.children[0].children[2];
    imgDim = img.getBoundingClientRect();
    FileReposition = function(event){
        img.style.x = ((offset.left + event.pageX - (imgDim.width/2))/5).toFixed(2) + "px";
        img.style.y = ((event.pageY - offset.top - (imgDim.height/2))/5).toFixed(2) + "px";
    }
    elem.addEventListener("mousemove", FileReposition, false);
    moveStop = true;
}

FileAPP.moveStop = function(id){
    if(moveStop === true){
        elem = S("#file" + id);
        elem.style.cursor = "default";
        elem.removeEventListener("mousemove", FileReposition);
        moveStop = false;
    }
}

FileAPP.moveSafe = function(id){
    var offset = S.offset("#file" + id);
    elem = S("#file" + id);
    img = elem.children[0].children[2];
    imgDim = img.getBoundingClientRect();
    xPos = ((offset.left + event.pageX - (imgDim.width/2))/5).toFixed(2) + "px";
    yPos = ((event.pageY - offset.top - (imgDim.height/2))/5).toFixed(2) + "px";
    Code.cssEdit("#" + img.id, {x: xPos, y: yPos});
    FileAPP.moveStop(id);
}

FileAPP.updateFile = function(id){
    S.popup(S.url() + 'File/query/admin/update-file', {id: id}, '#fileEditor');
}
var S = function(elem){return (elem instanceof Element) ? elem : document.querySelector(elem);}

S.all = function(elem, func){
    if (!func || typeof func !== 'function') return false;
    Select = document.querySelectorAll(elem);
	for (var i = 0; i < Select.length; i++) {
		func(Select[i], i);
	}
}

S.url = function(){
    return (S("#URL")) ? S("#URL").value : "/";
}

S.urlChange = function(url, title=false) {
    window.history.pushState('data', title, url);
    if(title !== false){document.title = title;}
}

S.serialize = function(formID){
    form = S(formID);
    var field, l, s = {};
    if (typeof form == 'object' && form.nodeName == "FORM") {
        var len = form.elements.length;
        for (var i=0; i<len; i++) {
            field = form.elements[i];
            
            if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
                if (field.type == 'select-multiple') {
                    l = form.elements[i].options.length; 
                    for (j=0; j<l; j++) {
                        if(field.options[j].selected)
                            s[field.name] = field.options[j].value;
                    }
                } else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
                    let names_select = document.getElementsByName(field.name);
                    if(field.type == 'checkbox' && names_select.length > 1){
                        for(d = 0; d < names_select.length; ++d){
                            if(names_select[d].checked){s[field.name.replace("[]", "") + "["+ d + "]"] = names_select[d].value;}
                        }
                    } else {
                        s[field.name] = field.value;
                    }
                }
            }
        }
    }
    return s;
};

S.jsonToURL = function(json){
    output = "";
    var a = 0;
    var key = 0;
    for (key in json) {
        if (json.hasOwnProperty(key)) {
            if(a > 0){output += "&";}
            output += key + "=" + encodeURIComponent(json[key]); 
        }
        a++;
    }
    return output;
}

S.scriptExec = function(string){
    if(string.indexOf('script') !== -1){
        var element = document.createElement('div');
        element.innerHTML = string;
        select = element.querySelectorAll("script");
    	for (var i = 0; i < select.length; i++){
    	    setTimeout(select[i].innerHTML, 50);
    	}
    	element = null;
    }
}

S.post = function(url, json={}, output=false, silent=false){
    if(output !== false){
        if(silent !== true){S.show("#loading");}
        fetch(url, {
            method: 'post',
            headers: {
              "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: S.jsonToURL(json)
        })
        .then(function(response){
            return response.text();
        })
        .then(function (data) {
            if(typeof output === 'function'){
                output(data);
            } else {
                S(output).innerHTML = data;
                S.scriptExec(data);
                //console.log('Request succeeded with JSON response', data);
            }
            if(silent !== true){S.hide("#loading");}
        })
        .catch(function (error) {
            //console.log('Request failed', error);
        });
    } else {
        fetch(url, {
            method: 'post',
            headers: {
              "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: S.jsonToURL(json)
        });
    }
    return false;
};

S.classAdd = function(el, addCls){
    S.all(el, function(elem){
        var arr = elem.className.split(" ");
        var cls = addCls.split(",");
        var output = elem.className;
        for (var a = 0; a < cls.length; a++){
            if (arr.indexOf(cls[a]) == -1) {
                output += " " + cls[a];
            }
        }
        elem.className = output;
    });
}

S.classRemove = function(el, remCls){
    S.all(el, function(elem){
        var cls = remCls.split(",");
        for (var a = 0; a < cls.length; a++){
            if(elem.className.indexOf(cls[a]) !== -1){
                var trimed = S.trim(cls[a]);
                var output = new RegExp(trimed.replace(/,/gi, "| "), "gi");
                output = elem.className.replace(output, "");
                elem.className = output.replace(/\s\s+/g, ' ');
            }
        }
    });
}

S.classToggle = function(el, toggleCls){
    if(el instanceof Element){
        if(el.classList.contains(toggleCls)){el.classList.remove(toggleCls);} else {el.classList.add(toggleCls);}
    } else {
        S.all(el, function(elem){
            if(elem.classList.contains(toggleCls)){elem.classList.remove(toggleCls);} else {elem.classList.add(toggleCls);}
        });
    }
}

S.trim = function(str){
    return str.replace(/\s+/g, '');
}


S.highlight = function(formID){
    S(formID).style.borderColor = "red";
};

S.inRange = function(val, maximum){
    if(val < 1){
        return Number(maximum);
    } else if(val > maximum){
        return 1;
    } else {
        return val;
    }
}

S.show = function(id){
    S.all(id, function(el){el.setAttribute("style", "display: block !important");});
}

S.hide = function(id){
    S.all(id, function(el){el.setAttribute("style", "display: none !important");});
}

S.toggle = function(id){
    S.all(id, function(el){
        if(el.style.display == "block"){
            el.setAttribute("style", "display: none !important");
        } else {
            el.setAttribute("style", "display: block !important");
        }
        
    });
}

S.css = function(css){
    if(document.getElementById("imasmi-css")){
        var node = document.getElementById("imasmi-css");
    } else {
        var node = document.createElement('style');
        node.setAttribute("id", "imasmi-css");
        document.head.appendChild(node);
    }
    node.innerHTML += css + "\r\n";
}

S.remove = function(elem){
    var elem = S(elem);
    return elem.parentNode.removeChild(elem);
}

S.info = function(message){
    if(!document.getElementById("info")){
        var info = document.createElement("info");
        info.setAttribute("id", "info");
        info.setAttribute("class", "popup");
        document.body.appendChild(info);
    }
    output = '<div id="" class="popup-close" onclick="S.remove(\'#info\')"></div>';
    output += '<div id="popup-content" class="popup-content padding-30">';
    output += message;
    output += '<button class="button margin-20" onclick="S.remove(\'#info\')">ok</button>';
    output += '</div>';
    document.getElementById("info").innerHTML = output;
    S.show("#info");
    return false;
}

S.popup = function(url, json=false, silent=false){
    if(!document.getElementById("popup")){
        var dyn = document.createElement("div");
        dyn.setAttribute("id", "popup");
        dyn.setAttribute("class", "popup");
        document.body.appendChild(dyn);
    }
    output = '<div id="" class="popup-close" onclick="S.popupExit()"></div>';
    
    output += '<div id="popup-content">' + (json===false ? url : '') + '</div>';
    document.getElementById("popup").innerHTML = output;
    if(json !== false){
        S.post(url, json, "#popup-content", silent);
    }
    S.show("#popup");
    document.body.style.overflow = "hidden";
    return false;
}

S.popupExit = function(){
    document.getElementById("popup").innerHTML = "";
    S.hide("#popup");
    document.body.style.overflow = "";
}

S.checkAll = function(val, elem){
	if(val.checked === true){
	    S.all(elem, function(el){el.checked = true;});
	} else {
		S.all(elem, function(el){el.checked = false;});
	}
}

S.visible = function(elem) {
    var el = S(elem);
    var rect = el.getBoundingClientRect();
    var viewportTop = window.pageYOffset || document.documentElement.scrollTop;
    var viewportBottom = viewportTop + window.innerHeight;
    var elementTop = rect.top + viewportTop;
    var elementBottom = elementTop + el.offsetHeight;

    if(elementBottom > viewportTop && elementTop < viewportBottom){
        return true;
    } else {
        return false;
    }
};

S.bind = function(func, actions = "load,resize,scroll", elem=window){
    actions.split(",").forEach(function(e){
        elem.addEventListener(e,func,false);
    });
}

S.animate = function(check_elem=".animation", add_class="animate", loop=false){
    S.all(check_elem, function(el){
        if(S.visible(el)){
            if(el.classList.contains(add_class) === false){el.classList.add(add_class);}
        } else if(loop){
            if(el.classList.contains(add_class) === true){el.classList.remove(add_class);}
        }
    });
}

S.slideTo = function(elem = "#index", arr = false){
    let pos = S(elem).getBoundingClientRect().top + window.scrollY;
    let currentPos = window.pageYOffset;
    let start = null;
    let time = arr.hasOwnProperty("time") ? arr["time"] : 500;
    pos = +pos, time = +time;
    window.requestAnimationFrame(function step(currentTime) {
        start = !start ? currentTime : start;
        let progress = currentTime - start;
        if (currentPos < pos) {
            window.scrollTo(0, ((pos - currentPos) * progress / time) + currentPos);
        } else {
            window.scrollTo(0, currentPos - ((currentPos - pos) * progress / time));
        }
        if (progress < time) {
            window.requestAnimationFrame(step);
        } else {
            window.scrollTo(0, pos);
        }
    });
    
}

S.computed = function(elem, prop=false){
    if(prop != false){
        return getComputedStyle(S(elem)).getPropertyValue(prop);
    } else {
        return getComputedStyle(S(elem));
    }
}

//Example: S.parallax("#example", {left: 2});
S.parallax = function(elem, arr){
    elem = elem || ".parallax";
    a = 1;
    var viewportTop = window.pageYOffset || document.documentElement.scrollTop;
    S.all(elem, function(el){
        rect = el.getBoundingClientRect();
        startPoint = viewportTop + rect.top;
            for(dir in arr){
                
                if(!el.querySelector("#parallaxStart")){
                    topStyle = getComputedStyle(el).getPropertyValue(dir);
                    topStart = topStyle.split("px");
                    el.innerHTML += '<input type="hidden" id="parallaxStart" value="' + startPoint + '"/>';
                }
                
                
                var newPos = Number(topStart[0]) + (viewportTop - Number(el.querySelector("#parallaxStart").value))/(arr[dir]);
                if(dir == "top"){
                    el.style.top = newPos + "px";
                } else {
                    el.style.left = newPos + "px";
                }
            }
        a++;
    });
}

S.unique = function(object){
    let output;
    if(Array.isArray(object)){
        output = [];
        for (let i = 0; i < object.length; i++){
            if (output.indexOf(object[i]) === -1 && object[i] !== ''){
                output.push(object[i]);
            }
        }
    } else {
        output = {};
        for (let key in object){
            if (Object.values(output).indexOf(object[key]) === -1 && object[key] !== ''){
                output[key] = object[key];
            }
        }
    }
    return output;
}

S.galleryItem = function(itemNumb, selector, cnt = false){
    let galleryID = selector + " #web-gallery";
    let gallery = S(galleryID);
    S.all(galleryID + " .web-gallery-item", function(el){ el.style.display = "none";});
    
    if(cnt){
        let current = Number(gallery.querySelector("#web-gallery-current").value);
        itemNumb = S.inRange(current + itemNumb, cnt);
    }
    gallery.querySelector("#web-gallery-item-" + itemNumb).style.display = "block";
    gallery.querySelector("#web-gallery-current").value = itemNumb;
    gallery.querySelector("#web-gallery-showing").innerHTML = itemNumb;
    gallery.style.display = "block";
}

// Add S.gallery(id) after the HTML with addEventListener if needed
//Items numbers can be added manually with data-gallery-item, or will receive default values in the order of appearance
S.gallery = function(selector){
    let gallery = {};
    let item_count = 0;
    S.all(selector + " .gallery-item", function(el){
        item_count = el.getAttribute("data-gallery-item") ? el.getAttribute("data-gallery-item") : ++item_count;
        gallery[item_count] = el.innerHTML;
        el.addEventListener("click", function(){S.galleryItem(this.getAttribute("data-gallery-item"), selector, item_count);});
    });

    let current = 1;
    let cnt = Object.keys(gallery).length;
    
    let newGallery = document.createElement("div");
    newGallery.setAttribute("id", "web-gallery");
    newGallery.setAttribute("class", "hide fixed fullscreen");
    newGallery.setAttribute("style", "top: 0; left: 0; z-index: 999;");
    let portrait = window.innerHeight > window.innerWidth ? true : false;
    let gal = '<div class="background black-bg" style="opacity: 0.5" onclick="S(\'' + selector + ' #web-gallery\').style.display = \'none\';"></div>';
    gal += '<a class="gallery-changer select-none" onclick="S.galleryItem(-1, \'' + selector + '\', ' + cnt + ')" style="position: absolute; color: #fff; cursor: pointer; outline: none; width: 50px; height: 50px; z-index: 2; left: 3%; top: 50%; transform: translateY(-50%) rotate(180deg);"><img class="fullscreen" src=\'/system/file/arrow.svg\'></a>';
    for(let i = 1; i <= cnt; i++){
        gal += '<div id="web-gallery-item-' + i + '" class="web-gallery-item contain' + (current != i ? ' hide': '') + '" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);' + (portrait ? 'width: 100vw!important; max-height: 100vh;' : 'height: 100vh!important; max-width: 100vw;') + '">' + gallery[i] + '</div>';
    }
    gal += '<a class="gallery-changer select-none" onclick="S.galleryItem(1, \'' + selector + '\', ' + cnt + ')" style="position: absolute; color: #fff; cursor: pointer; width: 50px; height: 50px; outline: none; right: 3%; top: 50%; transform: translateY(-50%);"><img class="fullscreen" src=\'/system/file/arrow.svg\'></a>';
    gal += '<div style="position: absolute; bottom: 5%; text-align: center; color: #fff; width: 100%;">Showing <span id="web-gallery-showing">' + current + '</span> of ' + cnt + '</div>';
    gal += '<a class="gallery-close select-none" onclick="S(\'' + selector + ' #web-gallery\').style.display = \'none\';" style="color: #fff; position: absolute; right: 30px; top: 30px; width: 50px; height: 50px;"><img class="fullscreen" src=\'/system/file/close.svg\'></a>';
    gal += '<input type="hidden" id="web-gallery-current" value="' + current + '"/>';
    newGallery.innerHTML = gal;
    S(selector).append(newGallery);
}

S.offset = function(el) {
    var rect = S(el).getBoundingClientRect(),
    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
}

S.parents = function(dataElem){
    p = [];
    for(var e = S(dataElem); e !== document; e = e.parentNode){
        p.push(e);
    }
    return p;
}

S.event = function(node, eventType) {
    var clickEvent = document.createEvent ('Event');
    clickEvent.initEvent (eventType, true, true);
    node.dispatchEvent (clickEvent);
}

S.back = function() {
    window.location=document.referrer;
}
var ListingAPP = function(){};

ListingAPP.inside = function(el){
    mousePos = event.clientY - document.body.getBoundingClientRect().top; // Get mouse position including scrolled offset
    elTop = S.offset(el).top;
    rowFrame = {top: elTop, bottom: elTop + el.offsetHeight};
    if(mousePos > rowFrame.top && mousePos < rowFrame.bottom && el.id){
        return true;
    }
    return false;
}

ListingAPP.drag = function(el){
   S(el).classList.add("row-drag");
   window.addEventListener("mousemove", ListingAPP.move,true);
};

var dragElement;

ListingAPP.move = function(){
    dragElement = S(".row-drag"); // The active element to be changed row
    dragElement.style.top = (event.clientY - 10) + "px";
    
    //  Detect mousemove on rows to chech for new position
    S.all(".listing-row", function(el){
        if(ListingAPP.inside(el) === true && el.id != dragElement.id){
            el.style.borderBottom = "60px solid #c45e5e";
        } else {
            el.style.borderBottom = "none";
        }
    });
};


ListingAPP.stopDrag = function(){
    dragElement.classList.remove("row-drag");
    window.removeEventListener("mousemove", ListingAPP.move, true);
    
    // Detect where mousemove end
    S.all(".listing-row", function(el){
        if(ListingAPP.inside(el) === true && el.id != dragElement.id){
            //Reorder row positions
            S.post(S.url() + "Listing/query/admin/row_reposition", 
            {"move-id" : dragElement.id.split("-")[1], "stop-id" : el.id.split("-")[1], "table" : el.getAttribute('data-table'), "order" : el.getAttribute('data-row-order'), "query" : el.getAttribute('data-row-query')}, 
            function(data){
                if(data == "ok"){
                    location.reload();
                } else {
                    console.log(data);
                }
                
            }
        );
        }
        el.style.borderBottom = "none";
    });
};


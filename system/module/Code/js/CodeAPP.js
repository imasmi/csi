var CodeAPP = function(){}

CodeAPP.cssSelector = function(el){
    elems = S.parents(el);
    var output = "";
    for(a = elems.length - 1; a >= 0; a--){
        if(elems[a].id){
            output += " #" + elems[a].id;
        }
    }
    return output.trim();
}

CodeAPP.cssEdit = function(selector, arr){
    S.post(S.url() + "Code/query/admin/edit-css?selector=" + encodeURIComponent(CodeAPP.cssSelector(selector)), arr);
}
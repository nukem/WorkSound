
// For Input Forms

function clearText(srcObj){
if(srcObj.title == srcObj.value) srcObj.value = "";
}

function writeText(srcObj){
if(srcObj.value == "") srcObj.value = srcObj.title;
}

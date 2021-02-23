/**
 * When the document is loaded:
 *      1) Update all lists.
 *      2) Update the dropdown 'Add' menu
 */
$(document).ready(function(){
    updateContent();
    updateMenu();
});

/**
 * Update dropdown menu to add 'Function' and 'Test'
 */
function updateMenu(){
    $(".sstmNBApp").show();
}

/**
 * Update 'Content' list.
 */
function updateContent(){
    $("#contentLoader").addClass("active");
    $.get("php/sstm_engine.php?method=appfct", function(data){
        $("#appContent *").remove();
        var msg = JSON.parse(data['message']);
        var myContent = '';
        var prevFct = '';
        var flagFirst = true;

        for(var m in msg){
            // Variables
            var fctID  = msg[m]['fctID'];
            var fctName= msg[m]['fctName'];

            var testID = msg[m]['testID'];
            var testNo = msg[m]['testNumber'];
            var testName=msg[m]['testName'];
            var testDesc=msg[m]['testDesc'];
            
            // Add Title
            if( fctName != prevFct ){
                // Close any previous opened list, if not first
                    if( flagFirst === false ){
                        myContent += "</div>";
                    }
                myContent += "<h2 class='ui header' data-fctID='" + fctID + "' style='cursor:pointer;' onclick='EditFunction(" + fctID + ");'>" + fctName + "</h2>";
                myContent += "<div class='ui celled list'>";
                flagFirst = false;
            }

            // Add Test if not null
            if( testID != null ){
                myContent += "<div class='item'><div class='content'><div class='header' style='cursor:pointer;' onclick='EditTest(" + testID + ");'>" + testNo + " - " + testName + "</div>";
                myContent += testDesc + "</div></div></div>";
            }else{
                myContent += "<div class='item'><div class='content'>(No test added yet)</div></div>";
            }
                
            // Store Function Name
            prevFct = fctName;
        }
        $("#appContent").append(myContent);
        $("#contentLoader").removeClass("active");
    });
}

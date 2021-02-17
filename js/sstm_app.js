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
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditApplication(?);"></i>';
        var myContent = '';
        var prevFct = '';

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
                myContent += "<h2 class='ui dividing header' data-testID='" + fctID + "'>" + fctName + "</h2>";
                myContent += "<div class='ui celled list'>";
            }

            // Add Test
                myContent += "<div class='item'><div class='content'><div class='header'>" + testNo + " - " + testName + "</div>";
                myContent += testDesc + "</div></div></div>";

            // Store Function Name
            prevFct = fctName;
        }
        $("#appContent").append(myContent);
        $("#contentLoader").removeClass("active");
    });
}

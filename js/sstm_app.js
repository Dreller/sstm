/**
 * When the document is loaded:
 *      1) Update all lists.
 */
$(document).ready(function(){
    updateContent();
});


/**
 * Update 'Content' list.
 */
function updateContent(){
    $("#contentLoader").addClass("active");
    $.get("php/sstm_engine.php?method=application-get", function(data){
        $("#appTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditApplication(?);"></i>';
        for(var m in msg){
            // Add line
            var packCode= msg[m]['packCode'];
            var appName = msg[m]['appName'];
            var newLine = "<tr><td>" + packCode + ' / ' + appName + editIcon.replace('?', msg[m]['appID']) + "</td></tr>";
            $("#appTableBody").append(newLine);
        }
        $("#appLoader").removeClass("active");
    });
}

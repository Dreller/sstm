
/**
 * When the document is ready:
 *      1) Update Cards
 */
$(document).ready(function(){
    updateCards();
});

/**
 * Build Phase Cards
 */
function updateCards(){
    $("#homeLoader").addClass("active");
    $("#cardsHolder div").remove();
    $.get("php/sstm_engine.php?method=homeCards", function(data){
        
        var msg = JSON.parse(data['message']);

        for(var m in msg){
            // Add line
            var suiteID = msg[m]['suiteID'];
            var suiteName= msg[m]['suiteName'];
            var phaName = msg[m]['phaName'];
            var newCard = "<div id='card_" + suiteID + "' class='ui segment'>";
            newCard += "<h2 class='ui dividing header'>" + suiteName + " / " + phaName + "</h2>";
            newCard += "<div class='ui placeholder'><div class='line'></div><div class='line'></div></div>";
            newCard += "</div>";

            $("#cardsHolder").append(newCard);
        }

        $("#homeLoader").removeClass("active");
    });
}

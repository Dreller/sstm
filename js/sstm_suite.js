/**
 * When the document is loaded:
 *      1) Update all lists.
 *      2) Update the dropdown 'Add' menu
 */
$(document).ready(function(){
    updateAll();
    updateMenu();
});

/**
 * Update dropdown menu to hide 'Function' and 'Test'
 */
function updateMenu(){
    $(".sstmNBApp").hide();
}

/** 
 * Update all lists at once.
 */
function updateAll(){
    $(".loader").addClass("active");
    updateApps();
    updatePackages();
    updateVersions();
    updateEnvironments();
    updatePhases();
}

/**
 * Update 'Packages' and 'Applications' lists at once.
 */
function updatePacksAndApps(){
    updatePackages();
    updateApps();
}

/**
 * The following functions will update lists separately.  I will 
 * keep them separated in case I want to add additional columns
 * for specific lists, or allow special treatments.
 */


/**
 * Update 'Applications' list.
 */
function updateApps(){
    $("#appLoader").addClass("active");
    $.get("php/sstm_engine.php?method=application-get", function(data){
        $("#appTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditApplication(?);"></i>';
        for(var m in msg){
            // Add line
            var packCode= msg[m]['packCode'];
            var appName = msg[m]['appName'];
            var newLine = "<tr><td><span style='cursor:pointer;' onclick='loadScreen(\"sstm_app.php?id=" + msg[m]['appID'] + "\");'>" + packCode + ' / ' + appName + '</span>' + editIcon.replace('?', msg[m]['appID']) + "</td></tr>";
            $("#appTableBody").append(newLine);
        }
        $("#appLoader").removeClass("active");
    });
}

/**
 * Update 'Versions' list
 */
function updateVersions(){
    $("#verLoader").addClass("active");
    $.get("php/sstm_engine.php?method=version-get", function(data){
        $("#verTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditVersion(?);"></i>';
        for(var m in msg){
            // Add line
            var verName = msg[m]['verName'];
            var newLine = "<tr><td>" + verName + editIcon.replace('?', msg[m]['verID']) + "</td></tr>";
            $("#verTableBody").append(newLine);
        }
        $("#verLoader").removeClass("active");
    });
}

/**
 * Update 'Test Phases' list
 */
function updatePhases(){
    $("#phaLoader").addClass("active");
    $.get("php/sstm_engine.php?method=phase-get", function(data){
        $("#phaTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditPhase(?);"></i>';
        for(var m in msg){
            // Add line
            var verName = msg[m]['phaName'];
            var newLine = "<tr><td>" + phaName + editIcon.replace('?', msg[m]['phaID']) + "</td></tr>";
            $("#phaTableBody").append(newLine);
        }
    });
    $("#phaLoader").removeClass("active");
}

/**
 * Update 'Environments' list
 */
function updateEnvironments(){
    $("#envLoader").addClass("active");
    $.get("php/sstm_engine.php?method=environment-get", function(data){
        $("#envTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditEnvironment(?);"></i>';
        for(var m in msg){
            // Add line
            var envName = msg[m]['envName'];
            var newLine = "<tr><td>" + envName + editIcon.replace('?', msg[m]['envID']) + "</td></tr>";
            $("#envTableBody").append(newLine);
        }
        $("#envLoader").removeClass("active");
    });
}

/**
 * Update 'Packages' list
 */
function updatePackages(){
    $("#packLoader").addClass("active");
    $.get("php/sstm_engine.php?method=package-get", function(data){
        $("#packTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditPackage(?);"></i>';
        for(var m in msg){
            // Add line
            var packCode = msg[m]['packCode'];
            var packName = msg[m]['packName'];
            var newLine = "<tr><td>" + packCode + ' - ' + packName + editIcon.replace('?', msg[m]['packID']) + "</td></tr>";
            $("#packTableBody").append(newLine);
        }
        $("#packLoader").removeClass("active");
    });
}

function updateAll(){
    $("#appLoader").addClass("active");
    $("#packLoader").addClass("active");
    $("#envLoader").addClass("active");
    $("#verLoader").addClass("active");
    updateApps();
    updatePackages();
    updateVersions();
    updateEnvironments();
}

function updateApps(){
    $("#appLoader").addClass("active");
    $.get("php/sstm_engine.php?method=application-get", function(data){
        $("#appTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditApplication(?);"></i>';
        for(var m in msg){
            // Add line
            var packName= msg[m]['packName'];
            var appName = msg[m]['appName'];
            var newLine = "<tr><td>" + packName + ' / ' + appName + editIcon.replace('?', msg[m]['appID']) + "</td></tr>";
            $("#appTableBody").append(newLine);
        }
        $("#appLoader").removeClass("active");
    });
}

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

function updatePackages(){
    $("#packLoader").addClass("active");
    $.get("php/sstm_engine.php?method=package-get", function(data){
        $("#packTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        var editIcon = '<i style="float:right;cursor: pointer;" class="edit icon" onclick="EditPackage(?);"></i>';
        for(var m in msg){
            // Add line
            var packName = msg[m]['packName'];
            var newLine = "<tr><td>" + packName + editIcon.replace('?', msg[m]['packID']) + "</td></tr>";
            $("#packTableBody").append(newLine);
        }
        $("#packLoader").removeClass("active");
    });
}

function updatePacksAndApps(){
    updatePackages();
    updateApps();
}

$('.dropdown').dropdown();

$(document).ready(function(){
    updateAll();
});
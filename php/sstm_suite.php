<?php 
session_start();
include_once('sstm_db.inc');

$ID = $_GET['id'];
$db->where('suiteID', $ID);
$suite = $db->getOne('suite');


?>
<p>&nbsp;<br>&nbsp;<br>&nbsp;<br></p>

<div id="suiteIntro" class="ui segment">
    <h2 class="ui dividing header"><?php echo $suite['suiteName']; ?></h2>
    <div class="ui placeholder">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>

<div class="ui two column relaxed grid">
    <div class="column">
        <div id="applications" class="ui segment">
            <h2 class="ui dividing header">Applications</h2>
            <div id="appLoader" class="ui loader"></div>
            <table id="appTable" class="ui celled table">
                <thead id="appTableHead">
                </thead>
                <tbody id="appTableBody">
                </tbody>
            </table>
        </div>
    </div>
    <div class="column">
        <div id="environments" class="ui segment">
            <h2 class="ui dividing header">Environments</h2>
            <div id="envLoader" class="ui loader"></div>
            <table id="envTable" class="ui celled table">
                <thead id="envTableHead">
                </thead>
                <tbody id="envTableBody">
                </tbody>
            </table> 
        </div>
        <div id="versions" class="ui segment">
            <h2 class="ui dividing header">Versions</h2>
            <div id="verLoader" class="ui loader"></div>
            <table id="verTable" class="ui celled table">
                <thead id="verTableHead">
                </thead>
                <tbody id="verTableBody">
                </tbody>
            </table> 
        </div>
    </div>
</div>


<script>

function updateAll(){
    $("#appLoader").addClass("active");
    $("#envLoader").addClass("active");
    $("#verLoader").addClass("active");
    updateApps();
    updateVersions();
    updateEnvironments();
}

function updateApps(){
    $("#appLoader").addClass("active");
    $.get("php/sstm_engine.php?method=apps-get&suite=<?php echo $ID; ?>", function(data){
        $("#appTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        for(var m in msg){
            // Add line
            var packName= msg[m]['packName'];
            var appName = msg[m]['appName'];
            var newLine = "<tr><td>" + packName + ' / ' + appName + "</td></tr>";
            $("#appTableBody").append(newLine);
        }
        $("#appLoader").removeClass("active");
    });
}

function updateVersions(){
    $("#verLoader").addClass("active");
    $.get("php/sstm_engine.php?method=vers-get&suite=<?php echo $ID; ?>", function(data){
        $("#verTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        for(var m in msg){
            // Add line
            var verName = msg[m]['verName'];
            var newLine = "<tr><td>" + verName + "</td></tr>";
            $("#verTableBody").append(newLine);
        }
        $("#verLoader").removeClass("active");
    });
}

function updateEnvironments(){
    $("#envLoader").addClass("active");
    $.get("php/sstm_engine.php?method=envs-get&suite=<?php echo $ID; ?>", function(data){
        $("#envTableBody tr").remove();
        var msg = JSON.parse(data['message']);
        for(var m in msg){
            // Add line
            var envName = msg[m]['envName'];
            var newLine = "<tr><td>" + envName + "</td></tr>";
            $("#envTableBody").append(newLine);
        }
        $("#envLoader").removeClass("active");
    });
}

$(document).ready(function(){
    updateAll();
});


</script>
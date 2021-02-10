<?php 
session_start();
include_once('sstm_db.inc');

$ID = $_GET['id'];
$db->where('ID', $ID);
$suite = $db->getOne('suite');



?>
<p>&nbsp;<br>&nbsp;<br>&nbsp;<br></p>

<div id="suiteIntro" class="ui segment">
    <h2 class="ui dividing header"><?php echo $suite['Name']; ?></h2>
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
            <table id="appTable" class="ui right aligned table">
                <thead id="appTableHead">
                    <tr>
                        <th class="left aligned">Name</th>
                    </tr>
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
            <table id="envTable" class="ui right aligned table">
                <thead id="envTableHead">
                    <tr>
                        <th class="left aligned">Name</th>
                    </tr>
                </thead>
                <tbody id="envTableBody">
                </tbody>
            </table> 
        </div>
        <div id="versions" class="ui segment">
            <h2 class="ui dividing header">Versions</h2>
            <div id="verLoader" class="ui loader"></div>
            <table id="verTable" class="ui right aligned table">
                <thead id="verTableHead">
                    <tr>
                        <th class="left aligned">Name</th>
                    </tr>
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
            var appName = msg[m]['Name'];
            var newLine = "<tr><th class='left aligned'>" + appName + "</td></tr>";
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
            var verName = msg[m]['Name'];
            var newLine = "<tr><th class='left aligned'>" + verName + "</td></tr>";
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
            var envName = msg[m]['Name'];
            var newLine = "<tr><th class='left aligned'>" + envName + "</td></tr>";
            $("#envTableBody").append(newLine);
        }
        $("#envLoader").removeClass("active");
    });
}

$(document).ready(function(){
    updateAll();
});


</script>
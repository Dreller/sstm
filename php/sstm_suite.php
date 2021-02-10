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
            <tr>
            <td class="left aligned">Delmar</td>
            </tr>
        </tbody>
    </table>
</div>

<script>

$(document).ready(function(){
    $.get("php/sstm_engine.php?method=apps-get&suite=<?php echo $ID; ?>", function(data){
        $("#appLoader").addClass("active");
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
});


</script>
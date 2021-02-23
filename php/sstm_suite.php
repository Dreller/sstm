<?php 
session_start();
include_once('sstm_db.inc');

$ID = $_GET['id'];
$_SESSION['current-suite'] = $ID;
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
        <div id="packages" class="ui segment">
        <h2 class="ui dividing header">Packages</h2>
            <div id="packLoader" class="ui loader"></div>
            <table id="packTable" class="ui celled table">
                <thead id="packTableHead">
                </thead>
                <tbody id="packTableBody">
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
        <div id="phases" class="ui segment">
            <h2 class="ui dividing header">Phases</h2>
            <div id="phaLoader" class="ui loader"></div>
            <table id="phaTable" class="ui celled table">
                <thead id="phaTableHead">
                </thead>
                <tbody id="phaTableBody">
                </tbody>
            </table> 
        </div>
    </div>
</div>


<script src="js/sstm_suite.js"></script>
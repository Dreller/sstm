<?php 
session_start();
include_once('sstm_db.inc');

$ID = $_GET['id'];
$_SESSION['current-app'] = $ID;
$db->where('appSuite', $_SESSION['current-suite']);
$db->where('appID', $ID);
$app = $db->getOne('application');

?>
<p>&nbsp;<br>&nbsp;<br>&nbsp;<br></p>

<div id="appIntro" class="ui segment">
    <h2 class="ui dividing header"><?php echo $app['appName']; ?></h2>
    <div class="ui placeholder">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>

<div class="ui segment">
<h2 class="ui dividing header">Content</h2>
<div id="contentLoader" class="ui loader"></div>



</div>

<script src="js/sstm_app.js"></script>
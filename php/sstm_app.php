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
    <h2 class="ui dividing header"><strong><?php echo $app['appName']; ?></strong> Test Plan</h2>
    <p><?php echo $app['appDesc']; ?>
</div>
<div id="contentLoader" class="ui loader"></div>
<div id="appContent" class="ui segment">
</div>

<script src="js/sstm_app.js"></script>
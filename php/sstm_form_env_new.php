<?php   
session_start();
include_once('sstm_db.inc');

$SYSTEM = $_GET['s'];

?>
<div class="ui form">
    <div class="field">
        <label>Environment name</label>
        <input type="text">
    </div>
</div>
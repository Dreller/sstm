<?php   
session_start();
include_once('sstm_db.inc');

?>
<div class="field">
    <label>Environment name</label>
    <input name="envName" id="envName" type="text" required>
</div>
<input type="hidden" name="method" value="env-new">

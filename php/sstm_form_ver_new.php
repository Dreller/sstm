<?php   
session_start();
include_once('sstm_db.inc');

?>
<div class="field">
    <label>Version name</label>
    <input name="verName" id="verName" type="text" required>
</div>
<input type="hidden" name="method" value="ver-new">
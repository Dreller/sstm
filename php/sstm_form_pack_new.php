<?php   
session_start();
include_once('sstm_db.inc');

?>
<div class="field">
    <label>Package name</label>
    <input name="packName" id="packName" type="text" required>
</div>
<input type="hidden" name="method" value="pack-new">
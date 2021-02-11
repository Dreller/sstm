<?php   
session_start();
include_once('sstm_db.inc');

$SYSTEM = $_GET['s'];

?>
<form id="odForm" class="ui form">
    <div class="field">
        <label>Package name</label>
        <input type="text">
    </div>
    <input type="hidden" name="method" value="pack-add">
    <input type="hidden" name="Suite" value="<?php echo $SYSTEM; ?>">
</form>
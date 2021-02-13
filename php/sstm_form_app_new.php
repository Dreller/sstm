<?php   
session_start();
include_once('sstm_db.inc');

# Get all Packages
$db->where('packSuite', $_SESSION['current-suite']);
$db->orderBy('packName', 'asc');
$packs = $db->get('package');

# Build Options list
$optList = "<option value=''></option>";
foreach($packs as $pack){
    $optList .= "<option value='{$pack['packID']}'>{$pack['packName']}</option>";
}

?>
<div class="field">
    <label>Package</label>
    <select name="appPackage" id="appPackage" class="ui search dropdown" required>
        <?php echo $optList; ?>
    </select>
</div>
<div class="field">
    <label>Application name</label>
    <input name="appName" id="appName" type="text" required>
</div>
<input type="hidden" name="method" value="app-new">
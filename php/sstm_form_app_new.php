<?php   
session_start();
include_once('sstm_db.inc');

$SYSTEM = $_GET['s'];

# Get all Packages
$db->where('packSystem', $SYSTEM);
$db->orderBy('packName', 'asc');
$packs = $db->get('package');

# Build Options list
$optList = "<option value=''></option>";
foreach($packs as $pack){
    $optList .= "<option value='{$pack['packID']}'>{$pack['packName']}</option>";
}

?>
<div class="ui form">
    <div class="field">
        <label>Package</label>
        <select class="ui search dropdown">
            <?php echo $optList; ?>
        </select>
    </div>
    <div class="field">
        <label>Application name</label>
        <input type="text">
    </div>
</div>
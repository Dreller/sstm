<?php   
session_start();
include_once('sstm_db.inc');

$thisMethod = "app-new";
$myID = 0;
$name = "";
$pack = "";

if( isset($_GET['id']) ){
    $myID = $_GET['id'];
    $db->where('appID', $myID);
    $db->where('appSuite', $_SESSION['current-suite']);
    $item = $db->getOne('application');

    if( $db->count !== 0 ){
        $thisMethod = "app-chg";
        $name = $item['appName'];
        $pack = $item['appPackage'];
    }
}


# Get all Packages
$db->where('packSuite', $_SESSION['current-suite']);
$db->orderBy('packName', 'asc');
$packs = $db->get('package');

# Build Options list
$optList = "<option value=''></option>";
foreach($packs as $p){
    $selected = '';
    if( $p['packID'] == $pack ){
        $selected = ' selected';
    }
    $optList .= "<option value='{$p['packID']}'$selected>{$p['packName']}</option>";
}


# Session storage to check consistency.
$_SESSION['current-item-id'] = $myID;
$_SESSION['current-method'] = $thisMethod;

?>
<div class="field">
    <label>Package</label>
    <select name="appPackage" id="appPackage" class="ui search dropdown" required>
        <?php echo $optList; ?>
    </select>
</div>
<div class="field">
    <label>Application name</label>
    <input name="appName" id="appName" type="text" value="<?php echo $name; ?>" required>
</div>
<input type="hidden" name="method" value="<?php echo $thisMethod; ?>">
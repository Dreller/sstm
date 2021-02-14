<?php   
session_start();
include_once('sstm_db.inc');

$thisMethod = "pack-new";
$myID = 0; 
$name = "";

if( isset($_GET['id']) ){
    $myID = $_GET['id'];
    $db->where('packID', $myID);
    $db->where('packSuite', $_SESSION['current-suite']);
    $item = $db->getOne('package');

    if( $db->count !== 0 ){
        $thisMethod = "pack-chg";
        $name = $item['packName'];
    }
}

# Session storage to check consistency.
$_SESSION['current-item-id'] = $myID;
$_SESSION['current-method'] = $thisMethod;

?>
<div class="field">
    <label>Package name</label>
    <input name="packName" id="packName" type="text" value="<?php echo $name; ?>" required>
</div>
<input type="hidden" name="method" value="<?php echo $thisMethod; ?>">
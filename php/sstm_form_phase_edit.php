<?php   
session_start();
include_once('sstm_db.inc');

$thisMethod = "pha-new";
$myID = 0;
$name = "";

if( isset($_GET['id']) ){
    $myID = $_GET['id'];
    $db->where('phaID', $myID);
    $db->where('phaSuite', $_SESSION['current-suite']);
    $item = $db->getOne('phase');

    if( $db->count !== 0 ){
        $thisMethod = "pha-chg";
        $name = $item['phaName'];
        $desc = $item['phaDesc'];
        $version = $item['phaVersion'];
        $environ = $item['phaEnvironment'];
    }
}


# Session storage to check consistency.
$_SESSION['current-item-id'] = $myID;
$_SESSION['current-method'] = $thisMethod;
?>
<div class="field">
    <label>Test Phase Name</label>
    <input name="phaName" id="phaName" type="text" value="<?php echo $name; ?>" required>
</div>
<input type="hidden" name="method" value="<?php echo $thisMethod; ?>">
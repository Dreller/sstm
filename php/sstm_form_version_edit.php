<?php   
session_start();
include_once('sstm_db.inc');

$thisMethod = "ver-new";
$myID = 0;
$name = "";

if( isset($_GET['id']) ){
    $myID = $_GET['id'];
    $db->where('verID', $myID);
    $db->where('verSuite', $_SESSION['current-suite']);
    $item = $db->getOne('version');

    if( $db->count !== 0 ){
        $thisMethod = "ver-chg";
        $name = $item['verName'];
    }
}


# Session storage to check consistency.
$_SESSION['current-item-id'] = $myID;
$_SESSION['current-method'] = $thisMethod;
?>
<div class="field">
    <label>Version name</label>
    <input name="verName" id="verName" type="text" value="<?php echo $name; ?>" required>
</div>
<input type="hidden" name="method" value="<?php echo $thisMethod; ?>">
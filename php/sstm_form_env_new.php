<?php   
session_start();
include_once('sstm_db.inc');

$thisMethod = "env-new";
$myID = 0; 
$name = "";

if( isset($_GET['id']) ){
    $myID = $_GET['id'];
    $db->where('envID', $myID);
    $db->where('envSuite', $_SESSION['current-suite']);
    $item = $db->getOne('environment');

    if( $db->count !== 0 ){
        $thisMethod = "env-chg";
        $name = $item['envName'];
    }
}

# Session storage to check consistency.
$_SESSION['current-item-id'] = $myID;
$_SESSION['current-method'] = $thisMethod;

?>
<div class="field">
    <label>Environment name</label>
    <input name="envName" id="envName" type="text" value="<?php echo $name; ?>" required>
</div>
<input type="hidden" name="method" value="<?php echo $thisMethod; ?>">

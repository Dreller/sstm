<?php   
/** 
 * Merge for SPAVE forms (Suite - Package - Application - Version - Environment)
 * GET values:  *type = suite
 *                      package
 *                      application
 *                      version
 *                      environment
 *              id    = ID of item to enter in EDIT mode.
 */
session_start();
include_once('sstm_db.inc');

# Catch Type
if( !isset($_GET['type']) ){
    echo "ERROR: Missing 'type' parameter.";
    die();
}

# Check if 'type' is valid
$thisType = strtolower($_GET['type']);
$okTypes = Array('suite', 'package', 'application', 'version', 'environment');
if( !in_array($thisType, $okTypes, TRUE) ){
    echo "ERROR: Type '$thisType' is not valid.";
    die();
}

# Determine fields for each Types
$sqlPrefix  = '';
$sqlTable   = $thisType;

$inputNames = Array('Name');
$inputTypes = Array('text');

    switch($thisType){
        case 'version':
            $sqlPrefix  = 'ver';
            $inputLabels = Array('Version Name');
            break;
        case 'environment':
            $sqlPrefix = 'env';
            $inputLabels = Array('Environment Name');
            break;
        case 'package':
            $sqlPrefix = 'pack';
            $inputLabels = Array('Package Name');
            break;
        case 'application':
            $sqlPrefix = 'app';
            $inputLabels = Array('Application Name');
            break;
    }

# Determine if we are in EDIT mode
$thisMode   = 'new';
$editMode   = false;
$thisID     = 0;
if( isset($_GET['id']) && $_GET['id'] != 0 ){

    $thisID     = $_GET['id'];
    # Reach the DB to get the data of the item
    $db->where($sqlPrefix."Suite", $_SESSION['current-suite']);
    $db->where($sqlPrefix."ID", $thisID);
    $item = $db->getOne($thisType);

    # If something is found, complete the change to 'chg'
    if( $db->count !== 0 ){
        $thisMode   = 'upd';
        $editMode   = true;
        # Create the 'actual data' array
        $data = Array();
        foreach( $inputNames as $inputName ){
            $data[$sqlPrefix.$inputName] = $item[$sqlPrefix.$inputName];
        }
    }
}

# Build 'Method' string
$thisMethod = "$thisType-$thisMode";

# Session storage to check consistency and post-treatment.
$_SESSION['current-item-id']    = $thisID;
$_SESSION['current-method']     = $thisMethod;


## Generate Form
$i = 0;
foreach($inputNames as $inputName ){
    $value = '';
    if( $editMode ){
        $value = $data[$sqlPrefix.$inputName];
    }
    echo '<div class="field">';
    echo '<label>'.$inputLabels[$i].'</label>';
    echo '<input type="'.$inputTypes[$i].'" name="'.$inputName.'" id="'.$inputName.'" value="'.$value.'" required>';
    echo '</div>';
    $i++;
}

# Pass method to form
echo '<input type="hidden" name="method" value="'.$thisMethod.'">';
?>
<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once("../php/sstm_db.inc");

$json = Array();
$json['status'] = 'oops';

# GET  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
if( isset($_GET['method']) && $_GET['method'] != '' ){
    $method = $_GET['method'];
    $input = $_GET;
}
# POST - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
if( getenv('REQUEST_METHOD') == 'POST' ){
    $raw = file_get_contents("php://input");
    $input = json_decode($raw, true);
    $method = $input["method"];
}
# At this point, if 'method' variable is not set, it means we were not
# able to determine what the call wants.
if( !isset($method) ){
    $json['message'] = '(SSTM) Unable to find a method in the call.';
    goto OutputJSON;
}

# Validate the method.  A method should be composed with 2 items:
# item-action.  Examples:  suite-set, application-get, version-upd.
$special = FALSE;
if( strpos($method, '-') != FALSE ){
    $x = explode('-', $method);
    $item   = $x[0];
    $action = $x[1];
}else{
    switch($method){
        case 'appfct':
            $special = TRUE;
            break;
    }
}

# If it's a special treatment, jump to it.
if( $special ){
    goto Specials;
}

# Validate item
$okItems = Array('suite', 'package', 'application', 'version', 'environment', 'function', 'test', 'phase');
if( !in_array($item, $okItems, TRUE) ){
    $json['message'] = "(SSTM) Method not valid: item '$item' it not allowed.";
    goto OutputJSON;
}

# Validate action 
$okActions = Array('set', 'get', 'add', 'new', 'upd', 'chg', 'del', 'rem');
if( !in_array($action, $okActions, TRUE) ){
    $json['message'] = "(SSTM) Method not valid: action '$action' it not allowed.";
    goto OutputJSON;
}

# Set item-dependant variables
$sqlPrefix = '';
$sqlSort   = '';

$callback  = '';

    switch($item){
        case 'version':
            $sqlPrefix = 'ver';
            $sqlSort   = $sqlPrefix.'Name';
            $callback  = 'updateVersions';
            break;
        case 'environment':
            $sqlPrefix = 'env';
            $sqlSort   = 'envOrder';
            $callback  = 'updateEnvironments';
            break;
        case 'package':
            $sqlPrefix = 'pack';
            $sqlSort   = $sqlPrefix.'Name';
            $callback  = 'updatePacksAndApps';
            break;
        case 'application':
            $sqlPrefix = 'app';
            $sqlSort   = 'packName';
            $callback  = 'updateApps';
            break;
        case 'function':
            $sqlPrefix = 'fct';
            $callback  = 'updateContent';
            break;
        case 'test':
            $sqlPrefix = 'test';
            $callback = 'updateContent';
            break;
        case 'phase':
            $sqlPrefix = 'pha';
            $callback = 'updatePhases';
            break;
    }



#====================================================================
# Action: SET
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
if( $action == 'set' ){
    $_SESSION["current-$item"] = $input['id'];
    $json['status'] = 'ok';
    $json['message']    = "$item set.";
    goto OutputJSON;
}
#====================================================================
# Action: GET
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
if( $action == 'get' ){
    $db->where($sqlPrefix.'Suite', $_SESSION['current-suite']);
    $db->orderBy($sqlSort, 'asc');

    # APPLICATION: Join Package infos
    if( $item == 'application' ){
        $db->join('package', 'appPackage = packID', 'LEFT');
        $db->orderBy('appName', 'asc');
    }

    $items = $db->get($item);
    
    $json['status']     = 'ok';
    $json['count']      = count($items);
    $json['message']    = json_encode($items);
    goto OutputJSON;
}

#====================================================================
# Action: NEW or ADD
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
if( $action == 'new' || $action == 'add' ){
    
    # Remove method from array
    unset($input['method']);
    # Remove ID if set
    if( isset($input['id']) ){
        unset($input['id']);
    }

    # Set new Data
    $new = $input;
    # Set Suite ID
    $new[$sqlPrefix."Suite"]    = $_SESSION['current-suite'];
    
        # For functions and tests, add Application ID
        if( $item == 'function' || $item == 'test' ){
            $new[$sqlPrefix."Application"]    = $_SESSION['current-app'];
        }

    $newID = $db->insert($item, $new);
    if( $newID ){
        $json['id']     = $newID;
        $json['status'] = 'callback';
        $json['message']= $callback;
    }else{
        $json['id']     = -1;
        $json['status'] = 'error';
        $json['message']= $db->getLastError();
    }

    # Override Callback for Packages - When adding a new package,
    # we just need to update the package list, not with apps too.
    if( $item == 'package' && $json['status'] == 'callback' ){
        $json['message'] = 'updatePackages';
    }

    goto OutputJSON;    
}
#====================================================================
# Action: UPD or CHG
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
if( $action == 'upd' || $action == 'chg' ){
    # Remove method
    unset($input['method']);
    # Remove ID if set
    if( isset($input['id']) ){
        unset($input['id']);
    }
    $db->where($sqlPrefix."ID", $_SESSION['current-item-id']);
    if( $db->update($item, $input) ){
        $json['status']  = 'callback';
        $json['message'] = $callback;
        $json['toast'] = $item." added";
        $json['toastType'] = 'success';
    }else{
        $json['status']  = 'error';
        $json['message'] = $db->getLastError();
    }
    goto OutputJSON;
}


#====================================================================
# Action: DEL or REM
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
if( $action == 'del' || $action == 'rem' ){
    $db->where($sqlPrefix."Suite", $_SESSION['current-suite']);
    $db->where($sqlPrefix."ID", $_SESSION['current-item-id']);
    if( $db->delete($item) ){
        $json['status'] = 'callback';
        $json['message']= $callback;
        $json['toast'] = $item . ' deleted';
    }else{
        $json['status'] = 'error';
        $json['message']= $db->getLastError();
        $json['toast'] = $db->getLastError();
        $json['toastType'] = 'error';
    }
    goto OutputJSON;
}


#====================================================================
# Action: ?
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
$json['message'] = "(SSTM) Don't know what to do.  Item $item, Action $action.";
goto OutputJSON;


# ===================================================================
# ============== S P E C I A L    T R E A T M E N T S ===============
# ===================================================================
Specials:
if( $method == 'appfct' ){
    # Request for a list of an app functions and tests 
    $db->where('fctApplication', $_SESSION['current-app']);
    $db->join('test', 'testFunction = fctID', 'LEFT');
    $db->orderBy('fctName', 'asc');
    $db->orderBy('testNumber', 'asc');
    $db->orderBy('testName', 'asc');

    $items = $db->get('function');

    $json['status']     = 'ok';
    $json['count']      = count($items);
    $json['message']    = json_encode($items);
    goto OutputJSON;
}

#====================================================================
# Special: ?
# . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
$json['message'] = "(SSTM) Don't know what to do, special treatment.  Item $item, Action $action.";
goto OutputJSON;


# Return the JSON
OutputJSON:
    header('Content-Type: application/json');
    $json['debug']      = "> ".$db->getLastQuery();
    echo json_encode($json);
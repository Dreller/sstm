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
    $json['message'] = "Unknown GET method: $method";
    
    if( $method == 'suite-set' ){
        $_SESSION['current-suite'] = $_GET['s'];
        $json['status'] = 'ok';
        $json['message'] = '';
        goto OutputJSON;
    }

    if( $method == 'apps-get' ){
        $db->where('appSuite', $_SESSION['current-suite']);
        $db->join('package', 'appPackage = packID', 'LEFT');
        $db->orderBy('packName', 'asc');
        $db->orderBy('appName', 'asc');
        $apps = $db->get('application');
        $json['status'] = 'ok';
        $json['count'] = count($apps);
        $json['message'] = json_encode($apps);
        goto OutputJSON;
    }
    if( $method == 'envs-get' ){
        $db->where('envSuite', $_SESSION['current-suite']);
        $db->orderBy('envOrder', 'asc');
        $envs = $db->get('environment');
        $json['status'] = 'ok';
        $json['count'] = count($envs);
        $json['message'] = json_encode($envs);
        goto OutputJSON;
    }
    if( $method == 'vers-get' ){
        $db->where('verSuite', $_SESSION['current-suite']);
        $db->orderBy('verName', 'asc');
        $vers = $db->get('version');
        $json['status'] = 'ok';
        $json['count'] = count($vers);
        $json['message'] = json_encode($vers);
        goto OutputJSON;
    }
    if( $method == 'pack-get' ){
        $db->where('packSuite', $_SESSION['current-suite']);
        $db->orderBy('packName', 'asc');
        $packs = $db->get('package');
        $json['status'] = 'ok';
        $json['count'] = count($packs);
        $json['message'] = json_encode($packs);
        goto OutputJSON;
    }

}

# POST - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
# If the engine gets data from a POST call
if( getenv('REQUEST_METHOD') == 'POST' ){
    $raw = file_get_contents("php://input");
    $input = json_decode($raw, true);
    $method = $input["method"];

    $json['message'] = "Unknown POST method: $method";

    # Add a new Suite
    if( $method == 'suite-new'){
        $newData = Array(
            'suiteAccount'   => $_SESSION['Account'],
            'suiteName'      => $input['Name']
        );
        $json['newID'] = $db->insert('suite', $newData);
        $json['status'] = 'callback';
        $json['message'] = '';
        goto OutputJSON;
    }
    # Add a new Package
    if( $method == 'pack-new'){
        $newData = Array(
            'packSuite'   => $_SESSION['current-suite'],
            'packName'     => $input['packName']
        );
        $json['newID'] = $db->insert('package', $newData);
        $json['status'] = 'ok';
        $json['message'] = '';
        goto OutputJSON;
    }
    # Add a new Environment
    if( $method == 'env-new'){
        $newData = Array(
            'envSuite'   => $_SESSION['current-suite'],
            'envName'     => $input['envName']
        );
        $json['newID'] = $db->insert('environment', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updateEnvironments';
        goto OutputJSON;
    }
    # Add a new Version
    if( $method == 'ver-new'){
        $newData = Array(
            'verSuite'   => $_SESSION['current-suite'],
            'verName'     => $input['verName']
        );
        $json['newID'] = $db->insert('version', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updateVersions';
        goto OutputJSON;
    }
    # Add a new Application
    if( $method == 'app-new'){
        $newData = Array(
            'appSuite'   => $_SESSION['current-suite'],
            'appPackage' => $input['appPackage'],
            'appName'    => $input['appName']
        );
        $json['newID'] = $db->insert('application', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updateApps';
        goto OutputJSON;
    }

    # Edit Environment
    if( $method == 'env-chg'){
        $newData = Array(
            'envName'     => $input['envName']
        );
        $db->where('envID', $_SESSION['current-item-id']);
        $db->where('envSuite', $_SESSION['current-suite']);
        $db->update('environment', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updateEnvironments';
        goto OutputJSON;
    }
    # Edit Version
    if( $method == 'ver-chg'){
        $newData = Array(
            'verName'     => $input['verName']
        );
        $db->where('verID', $_SESSION['current-item-id']);
        $db->where('verSuite', $_SESSION['current-suite']);
        $db->update('version', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updateVersions';
        goto OutputJSON;
    }
    # Edit Package
    if( $method == 'pack-chg'){
        $newData = Array(
            'packName'     => $input['packName']
        );
        $db->where('packID', $_SESSION['current-item-id']);
        $db->where('packSuite', $_SESSION['current-suite']);
        $db->update('package', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updatePacksAndApps';
        goto OutputJSON;
    }
    # Edit Application
    if( $method == 'app-chg'){
        $newData = Array(
            'appPackage' => $input['appPackage'],
            'appName'    => $input['appName']
        );
        $db->where('appID', $_SESSION['current-item-id']);
        $db->where('appSuite', $_SESSION['current-suite']);
        $db->update('application', $newData);
        $json['status'] = 'callback';
        $json['message'] = 'updateApps';
        goto OutputJSON;
    }
    


    

}


OutputJSON:
    header('Content-Type: application/json');
    echo json_encode($json);
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
    
    if( $method == 'apps-get' ){
        $db->where('appSuite', $_GET['suite']);
        $db->join('package', 'appPackage = packID', 'LEFT');
        $db->orderBy('packName', 'asc');
        $db->orderBy('appName', 'asc');
        $apps = $db->get('application');
        $temp = Array();
        foreach($apps as $app){
            $temp[] = $app;
        }

        $json['status'] = 'ok';
        $json['count'] = count($apps);
        $json['message'] = json_encode($temp);
        goto OutputJSON;
    }
    if( $method == 'envs-get' ){
        $db->where('envSuite', $_GET['suite']);
        $db->orderBy('envOrder', 'asc');
        $envs = $db->get('environment');
        $temp = Array();
        foreach($envs as $env){
            $temp[] = $env;
        }

        $json['status'] = 'ok';
        $json['count'] = count($envs);
        $json['message'] = json_encode($temp);
        goto OutputJSON;
    }
    if( $method == 'vers-get' ){
        $db->where('verSuite', $_GET['suite']);
        $db->orderBy('verName', 'asc');
        $vers = $db->get('version');
        $temp = Array();
        foreach($vers as $ver){
            $temp[] = $ver;
        }

        $json['status'] = 'ok';
        $json['count'] = count($vers);
        $json['message'] = json_encode($temp);
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
        goto OutputJSON;
    }
    # Add a new Package
    if( $method == 'pack-new'){
        $newData = Array(
            'packSystem'   => $input['System'],
            'packName'     => $input['Name']
        );
        $json['newID'] = $db->insert('suite', $newData);
        goto OutputJSON;
    }
    

}


OutputJSON:
    header('Content-Type: application/json');
    echo json_encode($json);
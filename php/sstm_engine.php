<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once('sstm_db.inc');

$json = Array();

# GET  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
if( isset($_GET['method']) && $_GET['method'] != '' ){
    



}

# POST - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
# If the engine gets data from a POST call
if( getenv('REQUEST_METHOD') == 'POST' ){
    $raw = file_get_contents("php://input");
    $input = json_decode($raw, true);
    $method = $input["method"];

    if( $method == 'auth' ){
        $json = [];
        goto OutputJSON;
    }
}


OutputJSON:
    header('Content-Type: application/json');
    echo json_encode($json);
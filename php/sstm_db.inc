<?php
require_once("mysqliDb.php");

# Read configs
$path = "php/.login.config";
if( !file_exists($path) ){
    $path = ".login.config";
}
$loginConfig = parse_ini_file($path, TRUE);

$dbHost = $loginConfig["Database"]["Host"];
$dbUser = $loginConfig["Database"]["User"];
$dbPass = $loginConfig["Database"]["Password"];
$dbName = $loginConfig["Database"]["Database"];
$dbPort = $loginConfig["Database"]["Port"];

if($dbPort != ""){
    $dbHost = $dbHost . ':' . $dbPort;
}

$db = new MysqliDb($dbHost, $dbUser, $dbPass, $dbName);

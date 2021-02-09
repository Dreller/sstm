<?php
require_once("mysqliDb.php");

# Read configs
$loginConfig = parse_ini_file('.login.config', TRUE);

$dbHost = $loginConfig["Database"]["Host"];
$dbUser = $loginConfig["Database"]["User"];
$dbPass = $loginConfig["Database"]["Password"];
$dbName = $loginConfig["Database"]["Database"];
$dbPort = $loginConfig["Database"]["Port"];

if($dbPort != ""){
    $dbHost = $dbHost . ':' . $dbPort;
}

$db = new MysqliDb($dbHost, $dbUser, $dbPass, $dbName);

<?php  
session_start();

$element = $_GET['el'];

# Table definition
switch($element){
    case "suite":
        $title      = 'Suites';
        $idName     = 'ID';
        $colNames   = Array('Name');
        $colLabels  = Array('Suite Name');
        $table      = "suite";
        $newModal   = "NewSuite";
        break;
    case "application":
        $title      = 'Applications';
        $idName     = 'ID';
        $colNames   = Array('Name');
        $colLabels  = Array('Suite Name');
        $table      = "suite";
        break;
}

require_once("mysqliDb.php");

# Read configs
$loginConfig = parse_ini_file('../.login.config', TRUE);

$dbHost = $loginConfig["Database"]["Host"];
$dbUser = $loginConfig["Database"]["User"];
$dbPass = $loginConfig["Database"]["Password"];
$dbName = $loginConfig["Database"]["Database"];
$dbPort = $loginConfig["Database"]["Port"];

if($dbPort != ""){
    $dbHost = $dbHost . ':' . $dbPort;
}

$db = new MysqliDb($dbHost, $dbUser, $dbPass, $dbName);

$db->where('Account', $_SESSION['Account']);
$lines = $db->get($table, null, $colNames);

    if( $db->count == 0 ){
        print '<p>&nbsp;</p><p>&nbsp;</p><div class="ui container">';
        print '<h2>' . $title . '</h2>';
        print '<div class="ui placeholder segment">';
        print '<div class="ui icon header">';
        print '<i class="expand icon"></i>';
        print 'Empty';
        print '</div><div class="ui primary button" onclick="displayModal(\''.$newModal.'\');">Add now</div></div></div>';
        die();
    }
?>
<div class="ui container">
    <table class="ui compact celled definition table">
        <thead class="full-width">
            <tr>
                <?php 
                    foreach($colLabels as $colLabel){
                        print "<th>$colLabel</th>";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($lines as $line){
                    print "<tr>";
                    foreach($colNames as $colName){
                        $value = $line[$colName];
                        print "<td>$value</td>"; 
                    }
                    print "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

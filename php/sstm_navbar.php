<?php   
session_start();
include_once('sstm_db.inc');

# Get Users's Account's Suites.
$db->where('suiteAccount', $_SESSION['userAccount']);
$db->orderBy('suiteName', 'asc');
$suites = $db->get('suite');

$suiteList = '';
foreach($suites as $suite){
    $suiteList .= '<a class="item" href="#" onclick="loadSuite('.$suite['suiteID'].')">'.$suite['suiteName'].'</a>';
}


?>

<div id="navbar" class="ui top fixed inverted main menu">
    <a href="#" class="header item">
        <img class="logo" src="php/sstm_thumbLetter.php">&nbsp;
        Account Name
    </a>
    <a href="#" class="item">Home</a>
    <div class="ui simple dropdown item">
        Suites <i class="dropdown icon"></i>
        <div class="menu">
            <?php print $suiteList; ?>
            <div class="divider"></div>
            <a class="item" href="#" onclick="displayModal('NewSuite');"><i class="plus circle icon"></i>&nbsp;New suite</a>
        </div>
    </div>

    <div id="navBarAdd" class="ui simple dropdown item disabled">
        Add <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#" onclick="NewTest();">Test</a>
            <a class="item" href="#" onclick="newItem('version');">Version</a>
            <a class="item" href="#" onclick="newItem('application');">Application</a>
            <a class="item" href="#" onclick="newItem('package');">Package</a>
            <a class="item" href="#" onclick="newItem('environment');">Environment</a>
        </div>
    </div>


        <div class="ui simple dropdown item right">
        Setup <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#" onclick="loadScreen('sstm_list.php?el=suite');">Suites</a>
            <a class="item" href="#" onclick="loadScreen('sstm_list.php?el=user');">Users</a>
            <a class="item" href="#">Parameters</a>
        </div>
    </div>
</div>

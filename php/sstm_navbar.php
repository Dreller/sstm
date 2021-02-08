<?php   


?>

<div id="navbar" class="ui top fixed inverted main menu">
    <a href="#" class="header item">
        <img class="logo" src="php/sstm_thumbLetter.php">&nbsp;
        Account Name
    </a>
    <a href="#" class="item">Home</a>
        <div class="ui simple dropdown item">
        Setup <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#" onclick="loadScreen('sstm_list.php?el=suite');">Suites</a>
            <div class="divider"></div>
            <div class="header">Quick access</div>
                <a class="item" href="#" onclick="loadScreen('sstm_list.php?el=test');">Tests</a>
                <a class="item" href="#" onclick="loadScreen('sstm_list.php?el=user');">Users</a>
            <div class="divider"></div>
            <div class="header">Other</div>
                <a class="item" href="#">Parameters</a>
            </div>
        </div>
    </div>
</div>

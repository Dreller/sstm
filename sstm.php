<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <style type="css/text">
        .ui#mainBox{
            padding-top: 55px;
        }
    </style>
</head>
<body>
<div class="main ui container row">
    <div class="row">
        <?php  
            include_once("php/sstm_navbar.php");
        ?>
    </div>
</div>
<div id="mainBox" class="ui container row"></div>


<!-- New Suite Modal -->  
<div id="modalNewSuite" class="ui modal">
    <i class="close icon"></i>
    <div class="header">New suite</div>
    <div class="content">
        <!-- Form -->  

    </div>
    <div class="actions">
        <div class="ui black deny button">
            Cancel
        </div>
        <div class="ui positive button">
            OK
        </div>
    </div>
</div>



<script src="js/jquery_3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>

<script>

    /**
        Load a screen in 'mainBox' div.
     */
    function loadScreen(name){
        $("#mainBox").load('php/' + name );
    }

    function displayModal(name){
        $("#modal" + name).modal('show');
    }
    function newSuite(){

    }

</script>

</body>
</html>
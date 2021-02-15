<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
        <div class="ui form">
            <form id="newSuite">
            <input type="hidden" id="method" name="method" value="suite-new" />
                <div class="field">
                    <label>Suite name</label>
                    <input type="text" id="Name" name="Name" required />
                </div>
            </form>
        </div>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            Cancel
        </div>
        <div id="bt_newSuiteOK" class="ui positive button" onclick="newSuite();">
            OK
        </div>
    </div>
</div>

<!-- On-demand Form Modal -->  
<div id="modalOnDemand" class="ui modal">
    <i class="close icon"></i>
    <div id="onDemandTitle" class="header"></div>
    <!-- Form -->  
    <form id="odForm" class="content ui form">
    

    </form>
    <div class="actions">
        <div class="ui black deny button" onclick="closeOnDemand();">
            Cancel
        </div>
        <div id="bt_odFormDelete" class="ui disabled negative button" onclick="sendOnDemandDelete();">
            Delete
        </div>
        <div id="bt_odFormOK" class="ui positive button" onclick="sendOnDemand();">
            OK
        </div>
    </div>
</div>


<div id="confirmDelete" class="ui basic modal">
    <div class="ui icon header">
        <i class="trash alternate outline icon"></i>
        Confirm deletion 
    </div>
    <div class="content">
        <p>Do you want to delete <span id="deleteItemName"></span> ?</p>
    </div>
    <div class="actions">
        <div class="ui red basic cancel inverted button">
            No
        </div>
        <div class="ui green ok inverted button" onclick="deletionOK();">
            Yes
        </div>
    </div>
</div>

<script src="js/jquery_3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="js/sstm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>
</html>
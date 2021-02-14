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
        <div class="ui black deny button">
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

<script>

var currentForm = '';
var currentSuite = 0;
var currentType = '';
var currentPrefix = '';

    /**
        Load a screen in 'mainBox' div.
     */
    function loadScreen(name){
        $("#mainBox").load('php/' + name );
    }
    function loadSuite(id){
        currentSuite = id;
        loadScreen('sstm_suite.php?id=' + id);
        $("#navBarAdd").removeClass("disabled");
    }

    function NewApplication(){
        $("#bt_odFormDelete").addClass("disabled");
        onDemandForm('spave_edit.php?type=application', "New Application");
    }
    function NewPackage(){
        $("#bt_odFormDelete").addClass("disabled");
        onDemandForm('spave_edit.php?type=package', "New Package");
    }
    function NewEnvironment(){
        $("#bt_odFormDelete").addClass("disabled");
        onDemandForm('spave_edit.php?type=environment', "New Environment");
    }
    function NewVersion(){
        $("#bt_odFormDelete").addClass("disabled");
        onDemandForm('spave_edit.php?type=version', "New Version");
    }

    function EditApplication(id){
        $("#bt_odFormDelete").removeClass("disabled");
        currentType = 'application';
        currentPrefix = 'app';
        onDemandForm('spave_edit.php?type=application&id=' + id, "Edit Application");
    }
    function EditEnvironment(id){
        $("#bt_odFormDelete").removeClass("disabled");
        currentType = 'environment';
        currentPrefix = 'env';
        onDemandForm('spave_edit.php?type=environment&id=' + id, "Edit Environment");
    }
    function EditVersion(id){
        $("#bt_odFormDelete").removeClass("disabled");
        currentType = 'version';
        currentPrefix = 'ver';
        onDemandForm('spave_edit.php?type=version&id=' + id, "Edit Version");
    }
    function EditPackage(id){
        $("#bt_odFormDelete").removeClass("disabled");
        currentType = 'package';
        currentPrefix = 'pack';
        onDemandForm('spave_edit.php?type=package&id=' + id, "Edit Package");
    }

    function onDemandForm(file, title){
        $("#onDemandTitle").html(title);
        $("#odForm").load('php/sstm_form_' + file, function(){
            $("#modalOnDemand").modal('show');
        });
    }
    function sendOnDemandDelete(){
        var desc = currentType + ' ' + $('#' + currentPrefix + 'Name').val();
        $("#deleteItemName").html(desc);
        $("#confirmDelete").modal('show');
    }
    function deletionOK(){
        var temp = new Object;
        temp['method'] = currentType + '-del';
        sendForm(JSON.stringify(temp));
    }

    function sendOnDemand(){
        setForm("odForm");
        setBtnLoad(true);
        if( !validateForm() ){
            setBtnLoad(false);
            return false;
        }
        sendForm(wrapForm());
    }
    function displayModal(name){
        $("#modal" + name).modal('show');
    }
    function newSuite(){
        setForm("newSuite");
        setBtnLoad(true);
        if( !validateForm() ){
            setBtnLoad(false);
            return false;
        }
        sendForm(wrapForm());
    }

    function setForm(formID){
        currentForm = formID;
    }

    function wrapForm(){
        var mixed_array = $('#' + currentForm).serializeArray();
        var sorted_array = {};
        $.map(mixed_array, function(n, i){
            sorted_array[n['name']] = n['value'];
        });
        var jsonWorker = JSON.stringify(sorted_array);
        return jsonWorker;
    }
    function validateForm(){
        var iErrors = 0;
        $("form#" + currentForm).find('input').each(function(){

            if( $(this).prop('required') ){
                if( isEmpty( $(this) )){
                    $(this).parent().parent().addClass('error');
                    console.log('Field ' + $(this).prop('id') + ' is required and empty.');
                    iErrors++;
                }else{
                    $(this).parent().parent().removeClass('error');
                }
            }
        });
        
        if( iErrors > 0 ){
            return false;
        }else{
            return true;
        }
    }
    function sendForm(jsonData, target){
        $.ajax({
            type: "POST",
            url: "php/sstm_engine.php",
            data: jsonData,
            success: function(result){
                processResult(result);
            }
        });
    }
    function processResult(myData){
        setBtnLoad(false);
        console.log(myData);

        if( myData['status'] == 'callback' ){
            var functionToCall = myData['message'];
            window[functionToCall]();
        }

    }
    function isEmpty(element){
        // Source: https://stackoverflow.com/a/6813294
        return !$.trim(element.val());
    }
    function setBtnLoad(activate){
        var btnID = "#bt_" + currentForm + "OK";
        if( activate === true ){
            $(btnID).addClass("loading");
        }else{
            $(btnID).removeClass("loading");
        }
    }    

    $('.ui.dropdown').dropdown();


</script>

</body>
</html>
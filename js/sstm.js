/**
 * Store the actual working form.  It allow to target the correct loader.
 * And to target the correct form when wrapping it to send to the server.
 */
var currentForm = '';
/**
 * Store the current item type (application, version, etc.)
 */
var currentType = '';
/**
 * Store the current item prefix
 */
var currentPrefix = '';

/**
 * Dropdowns
 */
$('.ui.dropdown').dropdown();

/**
 * Initialize TinyMCE
 */
function initializeRTE(){
    tinymce.init({
        selector:'.sstm_rte',
        toolbar_mode: 'sliding',
        statusbar:false,
        menubar: false,
        toolbar: "fontselect fontsizeselect backcolor forecolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | indent outdent subscript superscript | table"
    });
}

/**
 * Load a /php script in the mainBox container.
 * @param {String} name of PHP file from /php dir.
 */
function loadScreen(name){
    $("#mainBox").load('php/' + name );
}

/**
 * Load a suite in the scren.
 * @param {Number} id of the suite to load.
 */
function loadSuite(id){
    loadScreen('sstm_suite.php?id=' + id);
    $("#navBarAdd").removeClass("disabled");
}

/**
 * Open the screen to add a new item.
 * @param {String} what package | application | version | environment
 */
function newItem(what){
    onDemandForm('spave_edit.php?type=' + what, "New " + what, false);
}

/**
 * Open the corresponding screen to edit the item.
 * @param {Number} id of the item to edit.
 */
function EditApplication(id){
    currentType = 'application';
    currentPrefix = 'app';
    onDemandForm('spave_edit.php?type=application&id=' + id, "Edit Application", true);
}
function EditEnvironment(id){
    currentType = 'environment';
    currentPrefix = 'env';
    onDemandForm('spave_edit.php?type=environment&id=' + id, "Edit Environment", true);
}
function EditVersion(id){
    currentType = 'version';
    currentPrefix = 'ver';
    onDemandForm('spave_edit.php?type=version&id=' + id, "Edit Version", true);
}
function EditPackage(id){
    currentType = 'package';
    currentPrefix = 'pack';
    onDemandForm('spave_edit.php?type=package&id=' + id, "Edit Package", true);
}

/**
 * Open the On Demand Form.
 * @param {String} file from /php dir to use as form.
 * @param {String} title of the modal.
 * @param {Boolean} allowDelete true/false if the 'Delete' button should be enabled.
 */
function onDemandForm(file, title, allowDelete){
    $("#onDemandTitle").html(title);
    if( allowDelete ){
        $("#bt_odFormDelete").removeClass("disabled");
    }else{
        $("#bt_odFormDelete").addClass("disabled");
    }
    $("#odForm").load('php/sstm_form_' + file, function(){
        $("#modalOnDemand").modal('show');
        initializeRTE();
    });
}

/**
 * Open a modal to confirm Deletion of current item.
 */
function sendOnDemandDelete(){
    var desc = currentType + ' ' + $('#' + currentPrefix + 'Name').val();
    $("#deleteItemName").html(desc);
    $("#confirmDelete").modal('show');
}

function closeOnDemand(){
    $( ".sstm_rte" ).each(function() {
        tinymce.get($(this).attr("id")).destroy();
    });
    $("#modalOnDemand").modal('hide');
}

/**
 * Complete the deletion action from the On Demand Delete Button.
 */
function deletionOK(){
    var temp = new Object;
    temp['method'] = currentType + '-del';
    sendForm(JSON.stringify(temp));
}

/**
 * Send On Demand Form to SSTM Engine.
 */
function sendOnDemand(){
    setForm("odForm");
    setBtnLoad(true);
    if( !validateForm() ){
        setBtnLoad(false);
        return false;
    }
    sendForm(wrapForm());
}

/**
 * Open a modal.
 * @param {String} name 
 */
function displayModal(name){
    $("#modal" + name).modal('show');
}

/**
 * Open the form to add a new Suite.
 */
function newSuite(){
    setForm("newSuite");
    setBtnLoad(true);
    if( !validateForm() ){
        setBtnLoad(false);
        return false;
    }
    sendForm(wrapForm());
}

/**
 * Set the name of target form to 'currentForm'.
 * @param {String} formID 
 */
function setForm(formID){
    currentForm = formID;
}

/**
 * Wrap form to prepare data to be sent to SSTM Engine.
 * It uses the variable 'currentForm' to target the right one.
 */
function wrapForm(){
    var mixed_array = $('#' + currentForm).serializeArray();
    var sorted_array = {};
    $.map(mixed_array, function(n, i){
        sorted_array[n['name']] = n['value'];
    });
    // Update Array with RTF from RTE
    $( ".sstm_rte" ).each(function() {
        console.log("TinyMCE ID " + $(this).attr("id"));
        var thisRealID = $(this).attr("id");
        var thisRealContent = tinymce.get(thisRealID).getContent();
        sorted_array[thisRealID] = thisRealContent;
        tinymce.get(thisRealID).destroy();
    });
    var jsonWorker = JSON.stringify(sorted_array);
    return jsonWorker;
}

/**
 * Validate if the form is well filled.  See the validations below.
 * 
 * Validations
 * -----------
 *   1) Required fields are filled.
 *   -
 */
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

/**
 * Send JSON data to SSTM Engine.
 * @param {JSON} jsonData to send to the Engine.
 */
function sendForm(jsonData){
    $.ajax({
        type: "POST",
        url: "php/sstm_engine.php",
        data: jsonData,
        success: function(result){
            processResult(result);
        }
    });
}

/**
 * Catch the response from SSTM Engine and process it.
 * The 'status' will be one of:
 *   - ok: request completed.
 *   - error: there was an error handling the resquest, see 'message'.
 *   - callback: a function will handle 'myData', see 'message'.
 *  
 * Other data:
 *   - toast: If present, its content will be shown in a toast message.
 *   - toastType: Type of toast to display (error, success...).
 * 
 * @param {JSON} myData 
 */
function processResult(myData){
    setBtnLoad(false);
    console.log(myData);

    // Special treatments
    if( myData['status'] == 'callback' ){
        var functionToCall = myData['message'];
        window[functionToCall]();
    }

    // Toast
    if( myData['toast'] != undefined ){
        var tType = "";
        if( myData['toastType'] != undefined ){
            tType = myData['toastType'];
        }
        showToast(myData['toast'], tType);
    }
}

/**
 * Function to tell if an input is empty.
 * From: https://stackoverflow.com/a/6813294
 * @param {Object} element 
 */
function isEmpty(element){
    return !$.trim(element.val());
}

/**
 * Add/Remove loading indicator from the current form 'OK' button.
 * @param {Boolean} activate 
 */
function setBtnLoad(activate){
    var btnID = "#bt_" + currentForm + "OK";
    if( activate === true ){
        $(btnID).addClass("loading");
    }else{
        $(btnID).removeClass("loading");
    }
}

/**
 * Display a toast message
 * Source: https://codeseven.github.io/toastr/demo.html
 * 
 * @param {*} message to display
 * @param {*} type of message: info, warning, success, error
 */
function showToast(message, type = ""){

    toastr.options = {
        "closeButton":  false,
        "debug":        false,
        "progressBar":  true,
        "positionClass":"toast-bottom-center",
        "showDuration": 400
    }

    if( type == "success" ){
        toastr.success(message);
        return true;
    }
    if( type == "warning" ){
        toastr.warning(message);
        return true;
    }
    if( type == "error" ){
        toastr.error(message);
        return true;
    }

    toastr.info(message);
    return true;

}
 

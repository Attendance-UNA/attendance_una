/**
 * Contains the regular expressions to use in form validations
 */
const subcatgoryExpression = {
    name: /^[a-zA-ZÀ-ÿ0-9\s,]{1,49}$/,
    description: /^[a-zA-ZÀ-ÿ0-9\s,]{1,199}$/,
    justLetters: /^[a-zA-ZÀ-ÿ0-9]$/,
};

/**
 * Validate the available spaces of the form and report the error
 */
function validateForm(e) {
    switch (e.target.name) {
        case "name":
            validate(
                subcatgoryExpression.name,
                subcatgoryExpression.justLetters,
                e.target,
                e.target.id,
                "Este campo solo se permiten letras y numeros, con un maximo de 50 letras"
            );
            break;
        case "description":
            validateInputNotRequired(
                subcatgoryExpression.description,
                subcatgoryExpression.justLetters,
                e.target,
                e.target.id,
                "Este campo solo se permiten letras y numeros, con un maximo de 200 letras"
            );
            break;
    }
}

//-------------------------------------------------ATTENDANCE LIST---------------------------------------------------
/**
 * Clear form fields after making a registration
 */
function cleanFormSpaces() {
    document.getElementById("name").value = "";
    document.getElementById("description").value = "";
}

/**
 * Remove error alerts from form spaces
 */
function removeErrorInput() {
    document.getElementById("name").classList.remove("is-invalid");
    document.getElementById("description").classList.remove("is-invalid");
}

/**
 * Send new guest at the attendance list
 */
function submitGuest() {
    var urlAction = "";
    var idGuestVar = document.getElementById("idGuest").value;
    urlAction = "currentGuests/insert";
    var data = { idGuest: idGuestVar };
    $.ajax({
        type: "POST",
        url: urlAction,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        contentType: "application/json",
        dataType: "JSON",
        data: JSON.stringify(data),

        success: function (response) {
            if (response.success) {
                swal({
                    title: "¡" + response.message + "!",
                    text: "",
                    icon: "success",
                    timer: 2000,
                    button: "Ok"
                 });
                putCurrentGuests(response.currentGuests, response.currentPersons)
            } else {
                swal({
                    title: "¡" + response.message + "!",
                    text: "",
                    icon: "error",
                    timer: 2000,
                    button: "Ok"
                 });
            }
        },
        error: function (response) {
            swal(
                "¡Algo salió mal!",
                "Recargue e intente de nuevo" + idGuest,
                "error",
                { button: "Ok" }
            );
        },
    });
}

/**
 * Check the spaces of the form before being sent to registration
 */
function validateSubmit(flagAction) {
    var formSubcategory = document.getElementById("formSubcategory");
    var arrayFormGroups = formSubcategory.querySelectorAll("input");
    var flag = true;
    for (var i = 0; i < arrayFormGroups.length; i++) {
        if (arrayFormGroups[i].className.includes("is-invalid")) {
            flag = false;
        }
        if (
            arrayFormGroups[i].value === "" &&
            arrayFormGroups[i].required === true
        ) {
            validateEmptySpaces(true, arrayFormGroups[i].id);
            flag = false;
        }
    }
    if (flag === false) {
        swal("¡Ciertos campos no están correctamente!", "", "warning", {
            button: "Ok",
        });
    } else {
        submitData(flagAction);
    }
    return false;
}

function putCurrentGuests(guests,persons) {
    var table = document.querySelector("#table_list_guests");
    var stringTableBody = "";
    table.innerHTML = "";
    for (var i = 0; i < guests.length; i++) {
        //convert in twelve hours format
        const dateStr = guests[i].entry_hour;
        const [h, m, s] = dateStr.split(':');
        timeFormated = (h > 12 ? h- 12 : h)+':'+ m +' '+(h >= 12 ? "PM" : "AM");
        currentPerson=persons[i];

        stringTableBody += "<tr>";
        stringTableBody += "<td>" + timeFormated + "</td>";
        stringTableBody += "<td>" + guests[i].id_person + "</td>";
        stringTableBody += "<td>" + currentPerson[0].name + "</td>";
        stringTableBody += "<td>" + currentPerson[0].first_lastname+" "+currentPerson[0].second_lastname+ "</td>";
        stringTableBody += "</tr>";
    }
    table.innerHTML = stringTableBody;
}



function initializerEventListener() {
    //if the page is ready we can fade out the loading
    $(document).ready(function () {
        //Loading animation control
        $(".loading").fadeOut(1000);

        //Script for Html5QrcodeScanner use
        src = "/js/html5-qrcode.min.js";
        var lastResult, countResults = 0;
        function onScanSuccess(qrCodeMessage) {
            if (qrCodeMessage !== lastResult) {
                ++countResults;
                lastResult = qrCodeMessage;
                // Handle on success condition with the decoded message.
                //if we have the qr code put in this element
                document.getElementById("idGuest").value = qrCodeMessage;
                submitGuest();
            }       
        }

        function onScanError(errorMessage) {
            //handle scan error
        }

        var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: 250,
        });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    });

    var inputs = document.querySelectorAll("#formNewActivity input");
    inputs.forEach((input) => {
        if (input.type === "text") {
            input.addEventListener("keyup", validateForm);
            input.addEventListener("blur", validateForm);
        }
    });
}

//-----------------------------------Create Update Activity ---------------------------------------------------
function uploadSubCategoryList(){ 
    var urlAction = "";
    urlAction = "activitysubcategory/getlist";

    $.ajax({
        type: "POST",
        url: urlAction,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        contentType: "application/json",
        dataType: "JSON",
        data: {},
        contentType: false,
        processData: false,

        success: function (response) {
            if (response[0].success) {
                if (response[0].success == 1){
                    var combo = document.getElementById("subcategoryActivitySelect");
                    combo.innerHTML="";
                    var option = '<option value="null">' + "Seleccione..."+ '</option>';       
                    for (var i = 1; i < response.length; i++){
                        option += '<option value="'+response[i].id+'">' + response[i].name +" ("+ response[i].description+")"+ '</option>';             
                    }
                    combo.innerHTML=option;
                
                }else if(response[0].success == 0){
                    var option = "";
                    var combo = document.getElementById("subcategoryActivitySelect");
                    option += '<option value="null">' + "No hay registros"+ '</option>';
                    combo.innerHTML=option;
                }
            } else {
                 console.log("¡Error al consultar subcategorias en la base de datos!")
            }
        },
        error: function (response) {
            swal(
                "¡Algo salió mal!",
                "Recargue e intente de nuevo",
                "error",
                { button: "Ok" }
            );
        },
    });

}
function getAllActivities() {
    var table = document.querySelector("#table_list_activities");
    var stringTableBody = "";
    var urlAction = "";
    urlAction = "activities/getlist";

    $.ajax({
        type: "POST",
        url: urlAction,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        contentType: "application/json",
        dataType: "JSON",
        data: {},
        contentType: false,
        processData: false,

        success: function(response){
            table.innerHTML = '';

            for(var i = 1; i < response.length; i++){
               
                var params = {
                    param1: response[i].id,
                    param2: response[i].name,
                    param3: response[i].manager
                };

                stringTableBody += '<tr>';
                stringTableBody += '<td>' + response[i].date + '</td>';
                stringTableBody += '<td>' + response[i].name + '</td>';
                stringTableBody += '<td>' + response[i].manager + '</td>';
                stringTableBody += '<td><button onclick="editActivity(`' + response[i].id + '`)" class="btn btn-warning" disabled><i class="fas fa-pen fa-fw"></i> Editar</button></td>';
                stringTableBody += '<td><button onclick="sendPost(`' + params + '`)" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i> Iniciar</button></td>';
                stringTableBody += '</tr>';
            }
            table.innerHTML = stringTableBody;
        },
        error: function(response) { 
            console.log('Error al rescatar datos de las actividades: '+response);
        }
    });
}
function sendPost(params){ 
    var urlAction = "";
    urlAction = "startActivity";

    $.ajax({
        type: "POST",
        url: urlAction,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        contentType: "application/json",
        dataType: "JSON",
        data: params,
        contentType: false,
        processData: false,

        success: function (response) {           
            console.log("¡Error al consultar subcategorias en la base de datos!")
            
        },
        error: function (response) {
            swal(
                "¡Algo salió mal!",
                "Recargue e intente de nuevo",
                "error",
                { button: "Ok" }
            );
        },
    });

}
/**
 * Check the spaces of the form before being sent to registration
 */
 function validateSubmitActivity(flagAction) {
    var formActivity = document.getElementById('formCreateUpdateActivity');
    var arrayFormGroups = formActivity.querySelectorAll('input');
    var flag = true;
    for (var i = 0; i < arrayFormGroups.length; i++){

        if (arrayFormGroups[i].value === "" && arrayFormGroups[i].required === true){
            validateEmptySpaces(true, arrayFormGroups[i].id);
            flag = false;
        }else{
            removeWarningDivs(arrayFormGroups[i].id);
        }
    }
    if (flag === false){
        swal("¡Ciertos campos no se llenaron correctamente!","","warning",{button: "Ok"});

    }else if(document.querySelectorAll('#categoriesSubcategoriesSelectedTb tr').length==0){
        swal("¡Debe incluír al menos una categoría o subcategoría!","","warning",{button: "Ok"});
        
    }else{

        submitDataActivity(flagAction);
    }
    return false;
}
function submitDataActivity(flagAction) {
    // Activate animation loading send data
    $(".loading").fadeIn();

    var urlAction = '';
    var formActivity = document.getElementById('formCreateUpdateActivity');
    const formData = new FormData(formActivity);
    var arrayInputs = formActivity.getElementsByTagName('input');

    for (var i = 0; i < arrayInputs.length; i++){
        if (arrayInputs[i].type === "text"){
            formData.append(arrayInputs[i].name, arrayInputs[i].value);
        }
    }
    formData.append("CategorySubcategoryList", getCurrencyCategorySubcategoryList());

    if(flagAction){
        /**
         * If it is true, it is because the action of [Adding] is being sought.
         */
        urlAction = 'activity/insert';
    }else{
        /**
         * Enter from this side to execute the [Edit] action
         */
        urlAction = 'activity/update';
        formData.append('id_activity', document.getElementById('id_activity').value);
    }

    $.ajax({
        type: "POST",
        url: urlAction,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        success: function(response){
            if(response.success){
                $(".loading").fadeOut(1000);
                swal("¡"+response.message+"!","","success",{button: "Ok"});
                cleanFormSpacesActivity();
                getAllActivities();
            
            }else{
                swal("¡"+response.message+"!","Asegurese de editar algún campo","warning",{button: "Ok"});
                $(".loading").fadeOut(1000);
            }
        },
        error: function() { 
            $(".loading").fadeOut(1000);
            swal("¡Algo salió mal!","Recargue e intente de nuevo","error",{button: "Ok"}); 
        }
    });
}

/**
 * Clear form fields after making a registration
 */
 function cleanFormSpacesActivity() {
    document.getElementById('activityName').value = '';
    document.getElementById('activityDescription').value = '';
}

/**
 * Space to submit a change in the form to edit a subcategory
 */
function editActivity(idActivity){

    document.getElementById('btnUpdateActivity').hidden = false;
    document.getElementById('btnCreateActivity').hidden = true;

    document.getElementById('idActivity').value = idActivity;
    
}



function uploadSubCategoryList(){ 
    var urlAction = "";
    urlAction = "activitysubcategory/getlist";

    $.ajax({
        type: "POST",
        url: urlAction,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        contentType: "application/json",
        dataType: "JSON",
        data: {},
        contentType: false,
        processData: false,

        success: function (response) {
            if (response[0].success) {
                if (response[0].success == 1){
                    var combo = document.getElementById("subcategoryActivitySelect");
                    combo.innerHTML="";
                    var option = '<option value="null">' + "Seleccione..."+ '</option>';       
                    for (var i = 1; i < response.length; i++){
                        option += '<option value="'+response[i].id+'">' + response[i].name +" ("+ response[i].description+")"+ '</option>';             
                    }
                    combo.innerHTML=option;
                
                }else if(response[0].success == 0){
                    var option = "";
                    var combo = document.getElementById("subcategoryActivitySelect");
                    option += '<option value="null">' + "No hay registros"+ '</option>';
                    combo.innerHTML=option;
                }
            } else {
                 console.log("¡Error al consultar subcategorias en la base de datos!")
            }
        },
        error: function (response) {
            swal(
                "¡Algo salió mal!",
                "Recargue e intente de nuevo",
                "error",
                { button: "Ok" }
            );
        },
    });

}
function addSubcategoryToListTb(){
    var subcategorySelected = document.getElementById("subcategoryActivitySelect");

    if(subcategorySelected.options[subcategorySelected.selectedIndex].value!="null"){
        var id = subcategorySelected.value;
        var name = subcategorySelected.options[subcategorySelected.selectedIndex].text;

        if(validateCategorySubcategoryList(id)){
            swal({
                title: "¡Ya se encuentra en lista!",
                text: "",
                icon: "error",
                timer: 1000,
                button: "Ok"
             });
        }else{
            var list  = $("#categoriesSubcategoriesSelectedTb").html();
            var newSubCategories=""; 
            newSubCategories= '<tr id="'+id+'"><td>' + name + '</td></tr>';  
            subcategorySelected.options.selectedIndex=0;
            $("#categoriesSubcategoriesSelectedTb").html(list+newSubCategories);
        }
        

    }else{
        swal({
            title: "¡Seleccione una subcategoría!",
            text: "",
            icon: "error",
            timer: 2000,
            button: "Ok"
         });
    }
    

}
function addCategoryToListTb(){
    var categorySelected = document.getElementById("categoryActivitySelect");
    if(categorySelected.options[categorySelected.selectedIndex].value!="null"){
        var id = categorySelected.value;
        var name = categorySelected.options[categorySelected.selectedIndex].text;

        if(validateCategorySubcategoryList(id)){
            swal({
                title: "¡Ya se encuentra en lista!",
                text: "",
                icon: "error",
                timer: 1000,
                button: "Ok"
             });
        }else{
            var list  = $("#categoriesSubcategoriesSelectedTb").html();
            var newCategory=""; 
            newCategory= '<tr id="'+id+'"><td>' + name + '</td></tr>';  
            categorySelected.options.selectedIndex=0; //reset cbx to default selection
            $("#categoriesSubcategoriesSelectedTb").html(list+newCategory); //add to tb list of selections categories and subcategories
        }
        

    }else{
        swal({
            title: "¡Seleccione una categoría!",
            text: "",
            icon: "error",
            timer: 2000,
            button: "Ok"
         });
    }
    

}
//validate if this id category or id subcategory are in the tb list to this activity
function validateCategorySubcategoryList(id){

    const tableRows = document.querySelectorAll('#categoriesSubcategoriesSelectedTb tr')
    //go row by row the table
    for(let i=0; i<tableRows.length; i++) {
        if(id==tableRows[i].id){
            return true; //True if is already in the list
        }

    }
    return false;
}
//get id category and id subcategory if are in the tb list to this activity
function getCurrencyCategorySubcategoryList(){
    let idCategoriesSubcategoriesList = []
    const tableRows = document.querySelectorAll('#categoriesSubcategoriesSelectedTb tr')
    //go row by row the table
    for(let i=0; i<tableRows.length; i++) {
        idCategoriesSubcategoriesList.push(tableRows[i].id)
    }
    return idCategoriesSubcategoriesList;
}
function initializerEventListenerCreateActivity() {
    //if the page is ready we can fade out the loading
    $(document).ready(function () {
        uploadSubCategoryList();
        getAllActivities();
        //Loading animation control
        $(".loading").fadeOut(1000);

    });

    var inputs = document.querySelectorAll("#formCreateUpdateActivity input");
    inputs.forEach((input) => {
        if (input.type === "text") {
            input.addEventListener("keyup", validateForm);
            input.addEventListener("blur", validateForm);
        }
        
    });
}

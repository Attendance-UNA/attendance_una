/**
 * Contains the regular expressions to use in form validations
 */
const subcatgoryExpression = {
    name: /^[a-zA-ZÀ-ÿ0-9\s,]{1,49}$/,
    description: /^[a-zA-ZÀ-ÿ0-9\s,]{1,199}$/,
    justLetters: /^[a-zA-ZÀ-ÿ0-9]$/
}

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
                'Este campo solo se permiten letras y numeros, con un maximo de 50 letras'
            );
		break;
		case "description":
			validateInputNotRequired(
                subcatgoryExpression.description, 
                subcatgoryExpression.justLetters, 
                e.target, 
                e.target.id, 
                'Este campo solo se permiten letras y numeros, con un maximo de 200 letras'
            );
		break;
	}
}

/**
 * Clear form fields after making a registration
 */
function cleanFormSpacesSubcategory() {
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
}

/**
 * Remove error alerts from form spaces
 */
function removeErrorInputSubcategory() {
    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('description').classList.remove('is-invalid');
}
/**
 * Space to submit a change in the form to edit a subcategory
 */
function editSubcategory(idSubcategory, name, description){
    document.getElementById('divEditSubcategory').hidden = false;
    document.getElementById('divAddSubcategory').hidden = true;

    document.getElementById('divBtnEditSubcategory').hidden = false;
    document.getElementById('divBtnAddSubcategory').hidden = true;

    document.getElementById('id_subcategory').value = idSubcategory;
    document.getElementById('name').value = name;
    document.getElementById('description').value = description;

    removeErrorInputSubcategory();
}

/**
 * The option to edit a subcategory is reverted
 */
function cancelUpdateSubcategory() {
    document.getElementById('divEditSubcategory').hidden = true;
    document.getElementById('divAddSubcategory').hidden = false;

    document.getElementById('divBtnEditSubcategory').hidden = true;
    document.getElementById('divBtnAddSubcategory').hidden = false;

    document.getElementById('id_subcategory').value = '';
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';

    removeErrorInputSubcategory();
}

/**
 * Access the method that extracts the subcategories
 */
function getAllSubcategories() {
    var table = document.querySelector("#table_list_complemet");
    var stringTableBody = "";
    $.ajax({
        type: "GET",
        url: 'subcategory/getdata',
        success: function(response){
            table.innerHTML = '';
            for(var i = 0; i < response.length; i++){
                stringTableBody += '<tr>';
                stringTableBody += '<td>' + response[i].name + '</td>';
                stringTableBody += '<td>' + response[i].description + '</td>';
                stringTableBody += '<td><button onclick="editSubcategory(`' + response[i].id + '`, `' + response[i].name + '`, `' + response[i].description + '`)" class="btn btn-warning"><i class="fas fa-pen fa-fw"></i> Editar</button></td>';
                stringTableBody += '</tr>';
            }
            table.innerHTML = stringTableBody;
        },
        error: function(response) { 
            console.log('ERROR en el paso de datos: '+response);
        }
    });
}

/**
 * Send the data to be reviewed by the validations of the BE
 * and later be registered or updated and received a response
 */
function submitDataSubcategory(flagAction) {
    // Activate animation loading send data
    document.getElementById('loadingBySub').hidden = false;

    var urlAction = '';
    var formSubcategory = document.getElementById('formSubcategory');
    const formData = new FormData(formSubcategory);
    var arrayInputs = formSubcategory.getElementsByTagName('input');
    for (var i = 0; i < arrayInputs.length; i++){
        if (arrayInputs[i].type === "text"){
            formData.append(arrayInputs[i].name, arrayInputs[i].value);
        }
    }

    if(flagAction){
        /**
         * If it is true, it is because the action of [Adding] is being sought.
         */
        urlAction = 'subcategory/insert';
    }else{
        /**
         * Enter from this side to execute the [Edit] action
         */
        urlAction = 'subcategory/update';
        formData.append('id_subcategory', document.getElementById('id_subcategory').value);
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
                document.getElementById('loadingBySub').hidden = true;
                swal("¡"+response.message+"!","","success",{button: "Ok"});
                cleanFormSpacesSubcategory();
                getAllSubcategories();
                if(!flagAction){ cancelUpdateSubcategory(); }
            }else{
                swal("¡"+response.message+"!","Asegurese de editar algún campo","warning",{button: "Ok"});
                document.getElementById('loadingBySub').hidden = true;
            }
        },
        error: function() { 
            document.getElementById('loadingBySub').hidden = true;
            swal("¡Algo salió mal!","Recargue e intente de nuevo","error",{button: "Ok"}); 
        }
    });
}

/**
 * Check the spaces of the form before being sent to registration
 */
function validateSubmitSubcategory(flagAction) {
    var formSubcategory = document.getElementById('formSubcategory');
    var arrayFormGroups = formSubcategory.querySelectorAll('input');
    var flag = true;
    for (var i = 0; i < arrayFormGroups.length; i++){
        if (arrayFormGroups[i].className.includes('is-invalid')){
            flag = false;
        }
        if (arrayFormGroups[i].value === "" && arrayFormGroups[i].required === true){
            validateEmptySpaces(true, arrayFormGroups[i].id);
            flag = false;
        }
    }
    if (flag === false){
        swal("¡Ciertos campos no están correctamente!","","warning",{button: "Ok"});
    }else{
        submitDataSubcategory(flagAction);
    }
    return false;
}

/**
 * It is aware of what happens with the form fields
 */
function initializerEventListenerSubcategory() {
    var inputs = document.querySelectorAll("#formSubcategory input");
    inputs.forEach((input) => {
        if (input.type === "text"){
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        }
    });

    // Access the method that extracts the subcategories when the modal(section) is entered
    document.getElementById("subcategorySection").addEventListener("click", function(){
        cancelUpdateSubcategory();
        getAllSubcategories();
    });
}
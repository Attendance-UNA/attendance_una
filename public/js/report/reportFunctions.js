/**
 * Contains the regular expressions to use in form validations
 */
 const reportExpression = {
    nameActivity: /^[a-zA-ZÀ-ÿ0-9\s,]{1,99}$/,
    justLetters: /^[a-zA-ZÀ-ÿ0-9]$/,
}

/**
 * It is aware of what happens with the form fields
 */
 function initializerEventListenerReport () {

    // The section view is reset
    document.getElementById("typeReport").value = "none";
    document.getElementById('filterDate').hidden = true;
    document.getElementById('filterIdPerson').hidden = true;
    document.getElementById('filterNameActivity').hidden = true;
    document.getElementById('filterNamePerson').hidden = true;
}

/**
 *  Shows the filter space that the user selected
 */
function showFilterTypeReport () {
    var typeReport = document.getElementById('typeReport').value
    
    switch (typeReport) {
        case "nameActivity":
            document.getElementById('filterNameActivity').hidden = false;
            document.getElementById('filterNamePerson').hidden = true;
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
        case "date":
            document.getElementById('filterDate').hidden = false;
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterNamePerson').hidden = true;
        break;
        case "namePerson":
            document.getElementById('filterNamePerson').hidden = false;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
        case "idPerson":
            document.getElementById('filterIdPerson').hidden = false;
            document.getElementById('filterNamePerson').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
        default:
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('filterNamePerson').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
    }
}

/**
 * Send the request to delete the junk files of the pdf for report
 */
function deleteGarbageReportPDF() {
    $.ajax({
        type: "GET",
        url: 'report/deleteGarbageReportPDF',
        success: function(){ }
    });
}

/**
 * Send the request to request the data by the requested activity name
 */
function btnFilterNameActivity () {
    var nameActivity = document.getElementById('nameActivity').value // Extract the name of the activity
    if(nameActivity != ''){ // Check that it does not come empty
        const formData = new FormData();        
        formData.append('nameActivity', nameActivity); // Store the data to send it to controller

        $.ajax({
            type: "POST",
            url: 'report/dataNameActivity',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    sendDataReportNameActivity(response.data, response.activityData, nameActivity);
                }else{
                    swal(response.message,"","warning",{button: "Ok"});
                }
            },
            error: function() { 
                //document.getElementById('loadingBySub').hidden = true;
                //swal("¡Algo salió mal!","No existe actividad con el nombre ingresado","warning",{button: "Ok"}); 
                console.log('Algo esta fallando');
            }
        });
    }else{
        swal("¡Por favor llene el espacio de Actividad!","","warning",{button: "Ok"});
    }
}

/**
 * Send the request to generate the report by filtering the activity name
 */
 function sendDataReportNameActivity (packageData, activityData, nameActivity){
    const formDatax = new FormData();
    // Prepare the data to send to the controller
    formDatax.append('packageNameActivity', JSON.stringify(packageData));
    formDatax.append('activityData', JSON.stringify(activityData));
    
    $.ajax({
        type: 'POST',
        url: 'report/desingReportNameActivity',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formDatax,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response){
            // Redesign the report to print
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "Reporte actvidad "+nameActivity+".pdf";
            link.click();
            deleteGarbageReportPDF(); // Remove generated garbage from created report
        },
        error: function(){
            console.log('Error al generar reporte');
        }
    });
}

/**
 * Send the request to request the data by the date entered
 */
function btnFilterDate() {
    var dateReport = document.getElementById('dateReport').value
    if(dateReport != ''){
        const formData = new FormData();        
        formData.append('dateReport', dateReport);

        $.ajax({
            type: "POST",
            url: 'report/infoDateReport',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    sendDataReportByDate(response.data, dateReport);
                }else{
                    swal(response.message,"","warning",{button: "Ok"});
                }
            },
            error: function() { 
                //document.getElementById('loadingBySub').hidden = true;
                //swal("¡Algo salió mal!","No existe actividad con el nombre ingresado","warning",{button: "Ok"}); 
                console.log('Algo esta fallando en seccion fecha');
            }
        });

    }else{
        swal("¡Por favor seleccione una fecha!","","warning",{button: "Ok"});
    }
}

/**
 * Send the request to generate the report filtering the date
 */
function sendDataReportByDate(packageDateReport, date) {
    const formDatax = new FormData();
    // Prepare the data to send to the controller
    formDatax.append('packageDateReport', JSON.stringify(packageDateReport));
    formDatax.append('date', JSON.stringify(date));

    $.ajax({
        type: 'POST',
        url: 'report/desingReportDate',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formDatax,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response){
            // Redesign the report to print
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "Reporte por fecha ["+date+"].pdf";
            link.click();
            deleteGarbageReportPDF(); // Remove generated garbage from created report
        },
        error: function(){
            console.log('Error al generar reporte');
        }
    });
}

/**
 * Send the request to request the by person id
 */
function btnFilterIdPerson() {
    var idPerson = document.getElementById('idPerson').value
    if(idPerson != ''){
        const formData = new FormData();        
        formData.append('idPerson', idPerson);

        $.ajax({
            type: "POST",
            url: 'report/dataReportIdPerson',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    sendDataReportByIdPerson(response.person, response.activity);
                }else{
                    swal(response.message,"","warning",{button: "Ok"});
                }
            },
            error: function() { 
                //document.getElementById('loadingBySub').hidden = true;
                //swal("¡Algo salió mal!","No existe actividad con el nombre ingresado","warning",{button: "Ok"}); 
                console.log('Algo esta fallando en seccion cedula persona');
            }
        });

    }else{
        swal("¡Por favor llene el campo de cédula!","","warning",{button: "Ok"});
    }
}

/**
 * Send the request to generate the report filtering the person's identity card
 */
function sendDataReportByIdPerson(personData, activityArrayData) {
    const formDatax = new FormData();
    // Prepare the data to send to the controller
    formDatax.append('personData', JSON.stringify(personData));
    formDatax.append('activityArrayData', JSON.stringify(activityArrayData));

    $.ajax({
        type: 'POST',
        url: 'report/desingReportIdPerson',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formDatax,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response){
            // Redesign the report to print
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "Reporte por cédula "+personData.id+".pdf";
            link.click();
            deleteGarbageReportPDF(); // Remove generated garbage from created report
        },
        error: function(){
            console.log('Error al generar reporte');
        }
    });
}
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
            document.getElementById('tableActivityListReport').hidden = true;
            document.getElementById('tablePersonListReport').hidden = true;
            document.getElementById('filterNamePerson').hidden = true;
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('filterDate').hidden = true;
            document.getElementById("nameActivity").value = '';
        break;
        case "date":
            document.getElementById('filterDate').hidden = false;
            document.getElementById('tableActivityListReport').hidden = true;
            document.getElementById('tablePersonListReport').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterNamePerson').hidden = true;
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById("dateReport").value = '';
        break;
        case "namePerson":
            document.getElementById('filterNamePerson').hidden = false;
            document.getElementById('tableActivityListReport').hidden = true;
            document.getElementById('tableActivityListReport').hidden = true;
            document.getElementById('tablePersonListReport').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('filterDate').hidden = true;
            document.getElementById("firstNamePerson").value = '';
            document.getElementById("firstLastNamePerson").value = '';
            document.getElementById("secondLastNamePerson").value = '';
        break;
        case "idPerson":
            document.getElementById('filterIdPerson').hidden = false;
            document.getElementById('tableActivityListReport').hidden = true;
            document.getElementById('tablePersonListReport').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterNamePerson').hidden = true;
            document.getElementById('filterDate').hidden = true;
            document.getElementById("idPerson").value = '';
        break;
        default:
            document.getElementById('filterIdPerson').hidden = true;
            document.getElementById('tableActivityListReport').hidden = true;
            document.getElementById('tablePersonListReport').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterNamePerson').hidden = true;
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
        success: function(){
            document.getElementById('loadingByRep').hidden = true;
        }
    });
}

/**
 * Filter entered activity names and put them in a table
 */
function filterTableNameActivity() {
    document.getElementById('tableActivityListReport').hidden = true;
    var nameActivity = document.getElementById('nameActivity').value // Extract the name of the activity
    if(nameActivity !== ''){ // Check that it does not come empty
        const formData = new FormData(); 
        formData.append('nameActivity', nameActivity);
        
        $.ajax({
            type: "POST",
            url: 'report/requestTableNameActivity', // Communicates with the web.php class
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    createTableDataActivityName(response.data)
                }else{
                    swal(response.message,"","warning",{button: "Ok"});
                }
            },
            error: function() {
                swal("¡Algo salió mal!","Fallo en tabla nombre actividad [1]","error",{button: "Ok"});
            }
        });
    }else{
        swal("¡Por favor llene el espacio de nombre actividad!","","warning",{button: "Ok"});
    }
}

/**
 * Design and create the table with the activities
 */
function createTableDataActivityName(dataActivityNames) {
    var table = document.querySelector("#table_list_complemet_name_activity");
    var response = dataActivityNames;
    var stringTableBody = "";

    document.getElementById('tableActivityListReport').hidden = false;

    table.innerHTML = '';
    for(var i = 0; i < response.length; i++){
        stringTableBody += '<tr>';
        stringTableBody += '<td>' + response[i].name + '</td>';
        stringTableBody += '<td>' + response[i].date + '</td>';
        stringTableBody += '<td>' + response[i].description + '</td>';
        stringTableBody += '<td>' + response[i].manager + '</td>';
        stringTableBody += '<td><button onclick="filterReportNameActivity(`' + response[i].id + '`, `'+ response[i].name +'`)" class="btn btn-success"><i class="fa fa-download"></i> Generar</button></td>';
        stringTableBody += '</tr>';
    }
    table.innerHTML = stringTableBody;
}

/**
 * Extract the information required by the filtered activity name
 */
function filterReportNameActivity (idActivity, nameActivity) {
    // Activate animation loading send data
    document.getElementById('loadingByRep').hidden = false;
    const formData = new FormData();        
    formData.append('idActivity', idActivity); // Store the data to send it to controller

    $.ajax({
        type: "POST",
        url: 'report/requestDataNameActivity', // Communicates with the web.php class
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        success: function(response){
            // Once it obtains the data, it sends them to print the report
            document.getElementById('loadingByRep').hidden = true;
            printReportNameActivity(response.data, response.activityData, nameActivity);
        },
        error: function() {
            document.getElementById('loadingByRep').hidden = true;
            swal("¡Algo salió mal!","Fallo al obtener datos por nombre actividad [2]","error",{button: "Ok"});
        }
    });
}

/**
 * The report is printed by activity name with the data provided
 */
 function printReportNameActivity (attendanceData, activityData, nameActivity){
    const formDatax = new FormData();
    // Prepare the data (attendance & activity) to send to the controller
    formDatax.append('attendanceData', JSON.stringify(attendanceData));
    formDatax.append('activityData', JSON.stringify(activityData));
    
    $.ajax({
        type: 'POST',
        url: 'report/printReportNameActivity', // Communicates with the web.php class
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formDatax,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response){
            // Redesign the report to print and download
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "Reporte actvidad "+nameActivity+".pdf";
            link.click();
            deleteGarbageReportPDF(); // Remove generated garbage from created report
        },
        error: function(){
            document.getElementById('loadingByRep').hidden = true;
            swal("¡Algo salió mal!","Fallo al imprimir reporte por nombre actividad [3]","error",{button: "Ok"});
        }
    });
}

/**
 * Extract the information required by the date entered
 */
function filterReportDate() {
    var date = document.getElementById('dateReport').value
    if(date !== ''){
        // Activate animation loading send data
        document.getElementById('loadingByRep').hidden = false;

        const formData = new FormData();        
        formData.append('date', date);

        $.ajax({
            type: "POST",
            url: 'report/requestDataDate', // Communicates with the web.php class
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    printReportDate(response.data, date);
                }else{
                    document.getElementById('loadingByRep').hidden = true;
                    swal(response.message,"Verifique que la fecha este correcta","warning",{button: "Ok"});
                }
            },
            error: function() {
                document.getElementById('loadingByRep').hidden = true;
                swal("¡Algo salió mal!","Fallo al obtener datos por fecha [1]","error",{button: "Ok"});
            }
        });

    }else{
        swal("¡Por favor seleccione una fecha!","","warning",{button: "Ok"});
    }
}

/**
 * Print the date report with the data provided
 */
function printReportDate(attendanceData, date) {
    const formDatax = new FormData();
    // Prepare the data to send to the controller
    formDatax.append('attendanceData', JSON.stringify(attendanceData));
    formDatax.append('date', JSON.stringify(date));

    $.ajax({
        type: 'POST',
        url: 'report/printReportDate', // Communicates with the web.php class
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
            document.getElementById('loadingByRep').hidden = true;
            swal("¡Algo salió mal!","Fallo al imprimir reporte por fecha [2]","error",{button: "Ok"});
        }
    });
}

/**
 * Send the request to request the by person id
 */
function filterReportIdPerson() {
    var idPerson = document.getElementById('idPerson').value
    if(idPerson !== ''){
        // Activate animation loading send data
        document.getElementById('loadingByRep').hidden = false;

        const formData = new FormData();        
        formData.append('idPerson', idPerson);

        $.ajax({
            type: "POST",
            url: 'report/requestDataPerson', // Communicates with the web.php class
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    printReportPerson(response.person, response.attendance);
                }else{
                    document.getElementById('loadingByRep').hidden = true;
                    swal(response.message,"","warning",{button: "Ok"});
                }
            },
            error: function() { 
                document.getElementById('loadingByRep').hidden = true;
                swal("¡Algo salió mal!","Fallo al obtener datos por cédula persona [1]","error",{button: "Ok"});
            }
        });

    }else{
        swal("¡Por favor llene el campo de cédula!","","warning",{button: "Ok"});
    }
}

/**
 * Send the request to generate the report filtering the person's identity card
 */
function printReportPerson(personData, attendanceData) {
    const formDatax = new FormData();
    // Prepare the data to send to the controller
    formDatax.append('personData', JSON.stringify(personData));
    formDatax.append('attendanceData', JSON.stringify(attendanceData));

    $.ajax({
        type: 'POST',
        url: 'report/printReportPerson', // Communicates with the web.php class
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
            link.download = "Reporte de persona "+personData.id+".pdf";
            link.click();
            deleteGarbageReportPDF(); // Remove generated garbage from created report
        },
        error: function(){
            document.getElementById('loadingByRep').hidden = true;
            swal("¡Algo salió mal!","Fallo al imprimir reporte por persona [2]","error",{button: "Ok"});
        }
    });
}

/**
 * Filter entered names and place them in a table
 */
function filterTablePersonName() {
    document.getElementById('tablePersonListReport').hidden = true;
    var firstNamePerson = document.getElementById('firstNamePerson').value
    var firstLastNamePerson = document.getElementById('firstLastNamePerson').value
    var secondLastNamePerson = document.getElementById('secondLastNamePerson').value || ''

    if(firstNamePerson !== '' && firstLastNamePerson !== ''){
        // Pendiente el if que revisa la valicadion del segundo apellido
        const formData = new FormData();        
        formData.append('firstNamePerson', firstNamePerson);
        formData.append('firstLastNamePerson', firstLastNamePerson);
        formData.append('secondLastNamePerson', secondLastNamePerson);

        $.ajax({
            type: "POST",
            url: 'report/requestTableDataPerson', // Communicates with the web.php class
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    // Once it obtains the data, it sends them to print the report
                    createTableDataPersonName(response.data)
                }else{
                    swal(response.message,"","warning",{button: "Ok"});
                }
            },
            error: function() {
                swal("¡Algo salió mal!","Fallo en tabla nombre persona [1]","error",{button: "Ok"});
            }
        });
        
    }else{
        swal("¡Por favor llene los campos!","Debe de tener como mínimo nombre y primer apellido",
        "warning",{button: "Ok"});
    }
}

/**
 * Create and style the table with the filtered names
 */
function createTableDataPersonName(dataPersonsNames) {
    var table = document.querySelector("#table_list_complemet_name_person");
    var response = dataPersonsNames;
    var stringTableBody = "";

    document.getElementById('tablePersonListReport').hidden = false;

    table.innerHTML = '';
    for(var i = 0; i < response.length; i++){
        stringTableBody += '<tr>';
        stringTableBody += '<td>' + response[i].id + '</td>';
        stringTableBody += '<td>' + response[i].name + '</td>';
        stringTableBody += '<td>' + response[i].first_lastname + '</td>';
        stringTableBody += '<td>' + response[i].second_lastname + '</td>';
        stringTableBody += '<td><button onclick="filterReportNamePerson(`' + response[i].id + '`)" class="btn btn-success"><i class="fa fa-download"></i> Generar</button></td>';
        stringTableBody += '</tr>';
    }
    table.innerHTML = stringTableBody;
}

/**
 * Obtains the attendance data of the selected person
 */
function filterReportNamePerson(idPerson) {
    // Activate animation loading send data
    document.getElementById('loadingByRep').hidden = false;

    const formData = new FormData();        
    formData.append('idPerson', idPerson);

    $.ajax({
        type: "POST",
        url: 'report/requestDataPerson',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        success: function(response){
            // Once it obtains the data, it sends them to print the report
            document.getElementById('loadingByRep').hidden = true;
            printReportPerson(response.person, response.attendance);
            
        },
        error: function() { 
            document.getElementById('loadingByRep').hidden = true; 
            swal("¡Algo salió mal!","Fallo al obtener datos por nombre persona [2]","error",{button: "Ok"});
        }
    });
}
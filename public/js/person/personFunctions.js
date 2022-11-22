function submitDataPerson(){
    dimissAlert('div-download');
    var file = document.getElementById("xlsx_person").files[0];
    if (file == null || file.name.split(".")[1] != "xlsx"){
        swal("¡Por favor seleccione un archivo con extensión *.xlsx!","Asegurese de seleccionar el archivo con el formato solicitado","error",{button: "Ok"});
    }
    else{ 
        const data = new FormData();
        var urlAction = 'person/import';
        data.append("xlsx_person", file);
        document.getElementById('div-loading').classList.remove('d-none');// muestro pantalla de carga
        //ajax function
        $.ajax({
            type: "POST",
            url: urlAction,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function(response){
                document.getElementById('div-loading').classList.add('d-none');
                if(response.messageType == "success"){
                    swal("¡Transacción realizada correctamente!",response.message,"success",{button: "Ok"});
                    document.getElementById('download_ref').href = "files/docx/" + response.fileName;
                    document.getElementById('div-download').classList.remove('d-none');
                }else{
                    swal("¡Error!",response.message,"error",{button: "Ok"});
                }
            },
            error: function(e) {
                console.log(e); 
                document.getElementById('div-loading').classList.add('d-none');
                swal("¡Algo salió mal!","Recargue e intente de nuevo ","error",{button: "Ok"}); 
            }
        });
    }

    return false;
}

function downloadTemplate(){
    var urlAction = 'person/download_template';
    $.ajax({
        type: "GET",
        url: urlAction,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: null,
        contentType: false,
        processData: false,
        success: function(response){
            document.getElementById('div-loading').classList.add('d-none');
            if(response.messageType == "success"){
                
            }else{
                swal("¡Error!",response.message,"error",{button: "Ok"});
            }
        },
        error: function(e) {
            console.log(e); 
            document.getElementById('div-loading').classList.add('d-none');
            swal("¡Algo salió mal!","Recargue e intente de nuevo ","error",{button: "Ok"}); 
        }
    });
}

function initializerImportPersonModal(){
    document.getElementById('personSection').addEventListener("click", function(){
        document.getElementById('formUploadPerson').reset();
        dimissAlert('div-download');
    });
}

function dimissAlert(divName){
    document.getElementById(divName).classList.add("d-none");
}
function submitDataPerson(){
    dimissAlert('div-download');
    var file = document.getElementById("xlsx_person").files[0];
    if (file == null || file.name.split(".")[1] != "xlsx"){
        swal("¡Por favor seleccione un archivo con extensión *.xlsx!","Asegurese de seleccionar el archivo con el formato solicitado","error",{button: "Ok"});
    }
    else{ 
        const data = new FormData();
        data.append("xlsx_person", file);
        httpRequest = new XMLHttpRequest();
        httpRequest.open('POST', 'person/import', true);
        httpRequest.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].content);
        httpRequest.send(data);
        document.getElementById('div-loading').classList.remove('d-none');// muestro pantalla de carga
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === 4) {
                document.getElementById('div-loading').classList.add('d-none');
                console.log(httpRequest.responseText);
                var response = JSON.parse(httpRequest.responseText);
                if (response.messageType == "success"){
                    swal(response.message,"","success",{button: "Ok"});
                    document.getElementById('download_ref').href = "files/docx/" + response.fileName;
                    document.getElementById('div-download').classList.remove('d-none');
                }else{
                    swal(response.message,"","error",{button: "Ok"});
                }
            }
        };
    }

    return false;
}

function dimissAlert(divName){
    document.getElementById(divName).classList.add("d-none");
}
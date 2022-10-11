function submitData(){
    dimissAlert('div-error');
    dimissAlert('div-success');
    var file = document.getElementById("xlsx_person").files[0];
    if (file == null || file.name.split(".")[1] != "xlsx"){
        showMessage("div-error", "error-message", "¡Por favor seleccione un archivo con extensión *.xlsx!");
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
                var response = JSON.parse(httpRequest.responseText);
                if (response.messageType == "success"){
                    showMessage("div-success", "success-message", response.message);
                }else{
                    showMessage("div-error", "error-message", response.message);
                }
            }
        };
    }

    return false;
}

function showMessage(idAlertDiv,idMessageSpan, message){
    document.getElementById(idMessageSpan).innerHTML = message;
    document.getElementById(idAlertDiv).classList.remove("d-none");
}

function dimissAlert(divName){
    document.getElementById(divName).classList.add("d-none");
}
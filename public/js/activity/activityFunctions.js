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

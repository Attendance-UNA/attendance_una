/**
 *  Shows the filter space that the user selected
 */
function showFilterTypeReport() {
    var typeReport = document.getElementById('typeReport').value
    
    switch (typeReport) {
        case "nameActivity":
            document.getElementById('filterNameActivity').hidden = false;
            document.getElementById('filterNameAcademic').hidden = true;
            document.getElementById('filterIdAcademic').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
        case "date":
            document.getElementById('filterDate').hidden = false;
            document.getElementById('filterIdAcademic').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterNameAcademic').hidden = true;
        break;
        case "nameAcademic":
            document.getElementById('filterNameAcademic').hidden = false;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterIdAcademic').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
        case "idAcademic":
            document.getElementById('filterIdAcademic').hidden = false;
            document.getElementById('filterNameAcademic').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
        default:
            document.getElementById('filterIdAcademic').hidden = true;
            document.getElementById('filterNameAcademic').hidden = true;
            document.getElementById('filterNameActivity').hidden = true;
            document.getElementById('filterDate').hidden = true;
        break;
    }
}
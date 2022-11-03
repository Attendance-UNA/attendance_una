<!DOCTYPE html>
<html>
    <body>
        <!-- Show space to filter by activity name -->
        <div id="filterNameActivity" hidden="">
            <hr>
            <p>Ingrese el nombre de la actividad por filtrar</p>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group" id="div-nameActivity">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nameActivity" 
                            name="nameActivity" 
                            placeholder="Actividad"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-4">
                    <button 
                        type="button" 
                        class="btn btn-success"
                        onclick="return btnFilterNameActivity()"
                    >
                        <i class="fa fa-download"></i> Generar
                    </button>
                </div>
            </div>
        </div>
        <!-- Show space to filter by date -->
        <div id="filterDate" hidden="">
            <hr>
            <p>Ingrese la fecha por filtrar</p>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group" id="div-dateReport">
                        <input 
                            type="date" 
                            class="form-control" 
                            id="dateReport" 
                            name="dateReport" 
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-4">
                    <button 
                        type="button" 
                        class="btn btn-success"
                        onclick="return btnFilterDate()"
                    >
                        <i class="fa fa-download"></i> Generar
                    </button>
                </div>
            </div>
        </div>
        <!-- Shows the space to filter by name academic person -->
        <div id="filterNamePerson" hidden="">
            <hr>
            <p>Ingrese el nombre por filtrar</p>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group" id="div-firstNameAcedemic">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="firstNameAcedemic" 
                            name="firstNameAcedemic" 
                            placeholder="Nombre"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group" id="div-firstLastNameAcedemic">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="firstLastNameAcedemic" 
                            name="firstLastNameAcedemic" 
                            placeholder="Primer apellido"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group" id="div-secondLastNameAcedemic">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="secondLastNameAcedemic" 
                            name="secondLastNameAcedemic"
                            placeholder="Segundo apellido"
                        > 
                    </div>
                </div>
                <div class="col-md-4">
                    <button 
                        type="button" 
                        class="btn btn-success"
                        onclick=""
                    >
                        <i class="fa fa-download"></i> Generar
                    </button>
                </div>
            </div>
        </div>
        <!-- Shows the space to filter by identification academic person -->
        <div id="filterIdPerson" hidden="">
            <hr>
            <p>Ingrese la c&eacute;dula por filtrar</p>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group" id="div-idAcedemic">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="idPerson" 
                            name="idPerson" 
                            placeholder="Identificaci&oacute;n"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-4">
                    <button 
                        type="button" 
                        class="btn btn-success"
                        onclick="return btnFilterIdPerson()"
                    >
                        <i class="fa fa-download"></i> Generar
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
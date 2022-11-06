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
                            placeholder="Actividad"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-4">
                    <button 
                        type="button" 
                        class="btn btn-success"
                        onclick="return filterReportNameActivity()"
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
                        onclick="return filterReportDate()"
                    >
                        <i class="fa fa-download"></i> Generar
                    </button>
                </div>
            </div>
        </div>
        <!-- Shows the space to filter by name person -->
        <div id="filterNamePerson" hidden="">
            <hr>
            <p>Ingrese el nombre por filtrar</p>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group" id="div-firstNamePerson">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="firstNamePerson" 
                            name="firstNamePerson" 
                            placeholder="Nombre"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group" id="div-firstLastNamePerson">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="firstLastNamePerson" 
                            name="firstLastNamePerson" 
                            placeholder="Primer apellido"
                            required=""
                        > 
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group" id="div-secondLastNamePerson">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="secondLastNamePerson" 
                            name="secondLastNamePerson"
                            placeholder="Segundo apellido"
                        > 
                    </div>
                </div>
                <div class="col-md-4">
                    <button 
                        type="button" 
                        class="btn btn-warning"
                        onclick="return filterTablePersonName()"
                    >
                    <i class="fa fa-user"></i> Buscar
                        
                    </button>
                </div>
            </div>
            <!-- Sample table of names of people if requested -->
            @include('report/tableNamePersonFilterReportView')
        </div>
        <!-- Shows the space to filter by identification person -->
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
                        onclick="return filterReportIdPerson()"
                    >
                        <i class="fa fa-download"></i> Generar
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
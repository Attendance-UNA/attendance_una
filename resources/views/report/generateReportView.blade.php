<!DOCTYPE html>
<html>
    <!-- Un espacio de prueba -->
    <div hidden>
        <p>Para generar un reporte oprima el boton</p>
        <a href="{{ route('download_pdf') }}" class="btn btn-" style="background-color: yellowgreen;">
            Generar reporte de asistencias (PDF)
        </a>
    </div>
    <body>
        <div class="container h-100">
            <div class="card">
                <div class="card-header">
                    <h6>Consulta de reportes</h6>
                </div>
                <div class="card-body">
                    <form id="formReport">
                        <p>Seleccione el tipo de consulta que desea realizar</p>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group" id="div-typeReport">
                                    <select name="typeReport" id="typeReport" class="form-control">
                                        <option value="none">Ninguno</option>
                                        <option value="nameActivity">Nombre de actividad</option>
                                        <option value="date">Fecha</option>
                                        <option value="nameAcademic">Nombre de acad&eacute;mico</option>
                                        <option value="idAcademic">C&eacute;dula de acad&eacute;mico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button 
                                    type="button" 
                                    class="btn btn-primary"
                                    onclick="return showFilterTypeReport()"
                                >
                                    <i class="fa fa-arrow-right"></i> Siguiente
                                </button>
                            </div>
                        </div>
                        <!-- Section filtering report by activity name, date and person academic -->
                        @include('report/filtersReportView') 
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
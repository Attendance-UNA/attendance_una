<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</html>
<div>
    <p>Para generar un reporte oprima el boton</p>
    <a href="{{ route('download_pdf') }}" class="btn btn-" style="background-color: yellowgreen;">
        Generar reporte de asistencias (PDF)
    </a>
</div>
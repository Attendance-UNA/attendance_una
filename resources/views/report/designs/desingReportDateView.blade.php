<!DOCTYPE html>
<html>
    <body>
        <div>
            <div class="row">
                <div class="column" style="width: 78%;">
                    <br>
                    <h3>Fecha: {{ $date }}</h3><br>
                </div>
                <div class="column">
                    <img class="masthead-avatar mb-5" src="assets/img/attendanceUNA/logo-UNA.png" alt="">
                </div>
            </div>
        </div>
        <div>
            <h2><center>Reporte de asistencias por fecha</center></h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido 1</th>
                        <th>Apellido 2</th>
                        <th>Actividad</th>
                        <th>Presente</th>
                        <th>Hora entrada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packageDateReport as $aux)
                        @foreach($aux as $data)
                            <tr>
                                <td><center>{{$data->name}}</center></td>
                                <td><center>{{$data->first_lastname}}</center></td>
                                <td><center>{{$data->second_lastname}}</center></td>
                                <td><center>{{$data->nameActivity}}</center></td>
                                <td><center>{{$data->present}}</center></td>
                                <td><center>{{$data->entry_hour}}</center></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>


<style>
    img {
        padding:4px;
        width: 105px;
        height: 105px;
        background-color: #f5f5f5;
        border: 1px solid #C64343;
    }

    table {
        width: 100%;
    }

    table td,
    table th {
        color: #000000;
        padding: 10px;
    }

    table td {
        text-align: center;
        vertical-align: middle;
    }

    table td:last-child {
        font-size: 0.95em;
        line-height: 1.4;
        text-align: left;
    }

    table th {
        background-color: #DA4646;
        font-weight: 300;
    }

    table tr:nth-child(2n) {
        background-color: #FFFFFF;
    }

    table tr:nth-child(2n+1) {
        background-color: #E9C3C3;
    }

    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 110px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>
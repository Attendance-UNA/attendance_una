<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/report_style.css">
    </head>
    <body>
        <div>
            <div class="row">
                <div class="column" style="width: 78%;">
                    <br>
                    <h3>Fecha consultada: {{ $date }}</h3><br>
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
                    <!-- Prints the attendance data of the consulted date -->
                    @foreach($attendanceData as $aux)
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
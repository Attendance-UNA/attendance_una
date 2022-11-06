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
                    <label for=""><b>C&eacute;dula:</b> {{ $personData->id }}</label><br>
                    <label for=""><b>Nombre:</b> {{ $personData->name }}</label><br>
                    <label for=""><b>Apellido 1:</b> {{ $personData->first_lastname }}</label><br>
                    <label for=""><b>Apellido 2:</b> {{ $personData->second_lastname }}</label><br>
                    <label for=""><b>Categor&iacute;a:</b> {{ $personData->category }}</label><br>
                </div>
                <div class="column">
                    <img class="masthead-avatar mb-5" src="assets/img/attendanceUNA/logo-UNA.png" alt="">
                </div>
            </div>
        </div>
        <div>
            <h2><center>Reporte de asistencias por persona</center></h2>
            <table>
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Fecha</th>
                        <th>Ingreso</th>
                        <th>Presente</th>
                        <th>Encargado</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Prints the attendance data of the consulted person -->
                    @foreach($attendanceData as $aux)
                        @foreach($aux as $data)
                            <tr>
                                <td><center>{{$data->name}}</center></td>
                                <td><center>{{$data->date}}</center></td>
                                <td><center>{{$data->entry_hour}}</center></td>
                                <td><center>{{$data->present}}</center></td>
                                <td><center>{{$data->manager}}</center></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
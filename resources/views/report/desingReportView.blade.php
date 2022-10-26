<!DOCTYPE html>
<html>
    <div>
        <img class="masthead-avatar mb-5" src="assets/img/attendanceUNA/logo-UNA.png" width="100" height="100" alt="">
        <h2>Reporte de asistencias demo</h2>
    </div>
    <div>
        <body>
            <table>
                <thead style="background-color: crimson;">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido 1</th>
                        <th>Apellido 2</th>
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($persons as $person)
                        <tr>
                            <td>{{ $person->name }}</td>
                            <td>{{ $person->first_lastname }}</td>
                            <td>{{ $person->second_lastname }}</td>
                            <td>{{ $person->category }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </body>
    </div>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Lista de Invitados</title>
</head>
<body>
    <form method="post" action="{{ url('person/import') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <label for="xlsx_person">Lista de personas invitadas a la actividad(*.xlsx):</label>
        <input type="file" name="xlsx_person" id="xlsx_person"/>
        @if ($errors->has('xlsx_person'))
        <div class="alert alert-danger">
            <span class="text-danger">{{ $errors->first('xlsx_person') }}</span>
        </div>
        @endif
        <button type="submit">Subir archivo</button>
    </form>
    
</body>
</html>
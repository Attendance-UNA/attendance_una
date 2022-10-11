<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Lista de Invitados</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js', 'resources/css/app.scss'])
    <link href="{{ asset('css/loading.css') }}" rel="stylesheet">
    <script src="{{ asset('js/person/personFunctions.js') }}"></script>
</head>
<body>
    <!-- loading section -->
    <div class="d-none" id="div-loading">
        <div class="loading">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
        </div>
    </div>
    <!-- end loading section -->
    <!--Container section-->
    <div class="container">
        <!--card section-->
        <div class="card h-100">
            <!--Card body-->
            <div class="card-body">
                <!--form section-->
                <form  onsubmit="return submitData()">
                    <div class="mb-3">
                        <label for="xlsx_person" class="form-label">Lista de personas invitadas a la actividad(*.xlsx):</label>
                        <input type="file" name="xlsx_person" id="xlsx_person" class="form-control"/>
                    </div>
                    <div class="d-none" id="div-error">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <span class="text-danger" id="error-message"></span>
                            <button type="button" class="btn-close" onclick="dimissAlert('div-error')" aria-label="Close"></button>
                        </div>
                    </div>

                    <div class="d-none" id="div-success">
                        <div class="alert alert-success alert-dismissible fade show">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <span class="text-success" id="success-message"></span>
                            <button type="button" class="btn-close" onclick="dimissAlert('div-success')" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="d-none" id="div-download">
                        <a href="" id="download_ref">Descargar códigos QR (*.docx)</a>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Importar Datos</button>
                </form>
                <!-- end form section -->
            </div>
            <!-- end card body -->
        </div>
        <!--end card section-->
    </div>
    <!--end container section-->
</body>
</html>
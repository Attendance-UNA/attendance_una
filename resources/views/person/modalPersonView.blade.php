<!DOCTYPE html>
<html>
    <head>
        <title>Importar Lista Participantes</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Font Awesome icons (free version)-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <link href="css/loading.css" rel="stylesheet">
        <script src="js/person/personFunctions.js"></script>
    </head>
    <body>
        <!-- Charge loading animation form -->
        <div class="d-none" id="div-loading">
            <div class="loading" id="loading">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>
            </div>
        </div>
        <!-- Show the modal subcategory with section form and table data -->
        <div class="portfolio-modal modal fade" id="personSectionModal0" tabindex="-1" role="dialog" aria-labelledby="#personSectionModal0Label" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row justify-content-center text-center">
                                <div class="col-lg-10">
                                    <!-- subcategory Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary mb-0">Importar Lista Participantes</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                </div>
                            </div>
                            <!--Container section-->
                            <div class="container">
                                <!--card section-->
                                <div class="card h-100">
                                    <!--Card body-->
                                    <div class="card-body">
                                        <!--form section-->
                                        <form  onsubmit="return submitData()">
                                            <!-- file-->
                                            <div class="mb-3">
                                                <label for="xlsx_person" class="form-label">Default file input example</label>
                                                <input class="form-control" type="file" name="xlsx_person" id="xlsx_person">
                                            </div>
                                            <!-- end file-->
                                            <div class="d-none" id="div-error">
                                                <div class="alert alert-danger alert-dismissible fade show">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                                    </svg>
                                                    <span class="text-danger" id="error-message"></span>
                                                    <button type="button" class="close" onclick="dimissAlert('div-error')" aria-label="Close"></button>
                                                </div>
                                            </div>

                                            <div class="d-none" id="div-success">
                                                <div class="alert alert-success alert-dismissible fade show">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <span class="text-success" id="success-message"></span>
                                                    <button type="button" class="close" onclick="dimissAlert('div-success')" aria-label="Close"></button>
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
                            <br>
                            <div class="container">
                                <button class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times fa-fw"></i>Cerrar</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
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
                                        <form  onsubmit="return submitDataPerson()">
                                            <!-- file-->
                                            <div class="mb-3">
                                                <label for="xlsx_person" class="form-label">Lista de personas invitadas a la actividad(*.xlsx):</label>
                                                <input type="file" name="xlsx_person" id="xlsx_person" class="form-control"/>   
                                            </div>
                                            <!-- end file-->
                                            <br>
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
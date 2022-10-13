<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>AttendanceUNA-home</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet">
    <!-- Fonts CSS-->
    <link rel="stylesheet" href="css/heading.css">
    <link rel="stylesheet" href="css/body.css">
</head>

<body id="page-top">
    <!-- include general navbar blade-->
    @include('mainNavbar')
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image--><img class="masthead-avatar mb-5" src="assets/img/attendanceUNA/logo-UNA.png" alt="">
            <!-- Masthead Heading-->
            <h1 class="masthead-heading mb-0">Bienvenido</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="pre-wrap masthead-subheading font-weight-light mb-0">Registro de invitados - Control de asistencias - Reportes </p>
        </div>
    </header>
    <section class="page-section portfolio" id="newActivity">
        <div class="container">
            <!-- newActivity Section Heading-->
            <div class="text-center">
                <h2 class="page-section-heading text-secondary mb-0 d-inline-block">Iniciar una nueva Actividad</h2>
            </div>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- newActivity Grid Items-->
            <div class="row justify-content-center">
                <!-- newActivity Items-->
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#newActivityModal0">
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div><img class="img-fluid" src="assets/img/attendanceUNA/meeting.png" alt="Log Cabin" />
                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('person/sectionPersonView')
    <!-- new activity Modal-->
    <div class="portfolio-modal modal fade" id="newActivityModal0" tabindex="-1" role="dialog" aria-labelledby="#newActivityModal0Label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center text-center">
                            <div class="col-lg-10">
                                <!-- new activity Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary mb-0">Datos de la Actividad</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                            </div>
                        </div>
                        <form action="{{url('postFormToNewActivity')}}" method="post">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="activityName">Nombre de la actividad:</label>
                                        <input type="text" name="activityName" class="form-control" id="activityName" aria-describedby="nameHelp" placeholder="Ingrese el nombre de la actividad">
                                        <!-- <small id="nameHelp" class="form-text text-muted">Una pequeña descripcion de la actividad.</small> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="activityDescription">Descripci&oacuten de la actividad:</label>
                                        <input type="text" name="activityDescription"  class="form-control" id="activityDescription" placeholder="Ingrese una descripción acerca de la actividad">
                                    </div>
                                    <div class="form-group">
                                        <label for="activityManagername">Nombre del encargado:</label>
                                        <input type="text" name="activityManagername" class="form-control" id="activityManagername" placeholder="Ingrese el nombre completo">
                                    </div>
                                    <label for="activityName">Seleccione la(s) categor&iacutea(s) de asistentes:</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="categoryCheck1" class="form-check-input" id="categoryCheck1">
                                        <label class="form-check-label" for="categoryCheck1">Administrativos</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="categoryCheck2" class="form-check-input" id="categoryCheck2">
                                        <label class="form-check-label" for="categoryCheck2">Ac&aacutedemicos</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="categoryCheck3" class="form-check-input" id="categoryCheck3">
                                        <label class="form-check-label" for="categoryCheck3">Estudiantes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="categoryCheck4" class="form-check-input" id="categoryCheck4">
                                        <label class="form-check-label" for="categoryCheck4">Invitados</label>
                                    </div>


                                </div>

                                <div class="col-lg-4">
                                    <label for="activityName">Seleccione la(s) subcategor&iacutea(s) de asistentes:</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="subCategoryCheck">
                                        <label class="form-check-label" for="subCategoryCheck">Comisi&oacuten de emergencias</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="subCategoryCheck">
                                        <label class="form-check-label" for="subCategoryCheck">Estudiantes becados con ingreso en el 2022 Carrera de Informatica</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">

                                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Iniciar </button>

                                <button class="btn btn-danger" href="#" style="margin-left: 10px" data-dismiss="modal"><i class="fas fa-times fa-fw"></i>Cancelar</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal import person list-->
    @include('person/modalPersonView')

    <!-- include general footer blade-->
    @include('mainFooter')
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
    <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Contact form JS-->
    <script src="assets/mail/jqBootstrapValidation.js"></script>
    <script src="assets/mail/contact_me.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
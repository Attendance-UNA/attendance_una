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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="page-section portfolio" id="newActivity">
        <div class="container">
            <!-- newActivity Section Heading-->
            <div class="text-center">
                <h2 class="page-section-heading text-secondary mb-0 d-inline-block">Gestionar/Iniciar Actividades</h2>
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
                <div class="col-md-6 col-lg-4 mb-5" >
                    <div class="portfolio-item mx-auto" data-toggle="modal" onclick="location.href ='createactivities'" >
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div><img class="img-fluid" src="assets/img/attendanceUNA/meeting.png" alt="Log Cabin" />
                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('person/sectionPersonView')
    <!-- Section view subcategory portfolio -->
    @include('subcategory/sectionSubcategoryView')
    <!-- Section view report portfolio -->
    @include('report/sectionReportView')

    <!-- modal import person list-->
    @include('person/modalPersonView')
    <!-- subcategory section Modal-->
    @include('subcategory/modalSubcategoryView')
    <!-- report section Modal-->
    @include('report/modalReportView')

    <!-- include general footer blade-->
    @include('mainFooter')
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
    <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
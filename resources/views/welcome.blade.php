<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Freelancer - Start Bootstrap Theme</title>
        <!-- Font Awesome icons (free version)-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet">
        <!-- Fonts CSS-->
        <link rel="stylesheet" href="css/heading.css">
        <link rel="stylesheet" href="css/body.css">
    </head>
    <body id="page-top">
        <!-- Space that contains the navigation menu to the other sections -->
        <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
            <div class="container"><img class="img-fluid" src="asset/Logo-UNA.png" alt="Logo UNA" width="120" height="120" href="#page-top">
                <button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu <i class="fas fa-bars"></i></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#downloadTemplate">Descargar Plantilla</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#uploadTemplate">Cargar Plantilla</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#startMeeting">Iniciar reunión</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#subcategory">Subcategor&iacute;as</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#report">Reportes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="masthead bg-danger text-white text-center">
            <section class="page-section portfolio" id="portfolio">
                <div class="container">
                    <!-- Portfolio Section Heading-->
                    <div class="text-center">
                        <h2 class="page-section-heading text-white mb-0 d-inline-block">SUBCATEGORÍA</h2>
                    </div>
                    <!-- Icon Divider-->
                    <div class="divider-custom">
                        <div class="divider-custom-line"></div>
                        <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                        <div class="divider-custom-line"></div>
                    </div>
                    <!-- Portfolio Grid Items-->
                    <div class="row justify-content-center">
                        <!-- Portfolio Items-->
                        <div class="col-md-6 col-lg-4 mb-5">
                            <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal0">
                                <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                    <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-1x"></i></div>
                                </div>
                                <button class="btn btn-primary"><i class="fas fa-plus fa-fw"></i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="divider-custom">
                        <table class="table table-striped table-dark">
                            <thead>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripci&oacute;n</th>
                                <th scope="col">Acci&oacute;n</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">Comision de seguridad</td>
                                    <td>Grupo de seguridad cantonal y regional</td>
                                    <td><button class="btn btn-warning"><i class="fas fa-pen fa-fw"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td scope="row">Estudiantes becados</td>
                                    <td>Contiene todos los estudiantes que reciben un beneficio o apoyo economico</td>
                                    <td><button class="btn btn-warning"><i class="fas fa-pen fa-fw"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td scope="row">Grupo de baile</td>
                                    <td>Grupo de estudiantes y profesores involucrados en las actividades de danza</td>
                                    <td><button class="btn btn-warning"><i class="fas fa-pen fa-fw"></i> Editar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </header>
        
        <!-- Portfolio Modal-->
        <div class="portfolio-modal modal fade" id="portfolioModal0" tabindex="-1" role="dialog" aria-labelledby="#portfolioModal0Label" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    <div class="modal-body text-center">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Portfolio Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary mb-0">Nueva subcategor&iacute;a</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-plus"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Portfolio Modal - Text-->
                                    <p class="mb-5">Ingrese el nombre y la descripci&oacute;n para añadir una nueva subcategor&iacute;a.</p>
                                    <div>
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nameSubcategory" placeholder="Ingrese el nombre">
                                            </div>
                                            <div class="form-group">
                                                <input type="description" class="form-control" id="descriptionSubcategory" placeholder="Descripción">
                                            </div><br>
                                            <button type="submit" class="btn btn-success"><i class="fas fa-check fa-fw"></i> Guardar</button>
                                            <button class="btn btn-danger" href="#" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="mb-4">DIRECCIÓN</h4>
                        <p class="pre-wrap lead mb-0">Horquetas, Sarapiquí, Heredia. Costa Rica</p>
                        <p class="pre-wrap lead mb-0">Sede Región Huetar Norte y Caribe, Campus Sarapiquí</p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="mb-4">ALREDEDOR DE LA WEB</h4><a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/UNACampusSarapiqui/"><i class="fab fa-fw fa-facebook-f"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://twitter.com/ComunidadUNACR/"><i class="fab fa-fw fa-twitter"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.instagram.com/una.ac.cr/"><i class="fab fa-fw fa-instagram"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.srhnc.una.ac.cr"><i class="fab fa-fw fa-dribbble"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="mb-4">VISIÓN</h4>
                        <p class="pre-wrap lead mb-0">Somos la Sección Regional de la Universidad Nacional creada para formar profesionales integrales mediante la docencia, investigación, extensión y producción con el fin de contribuir al desarrollo sustentable de la Región Huetar Norte y Caribe</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Copyright Section-->
        <section class="copyright py-4 text-center text-white">
            <div class="container"><small class="pre-wrap">Copyright © 2022 Campus Sarapiquí</small></div>
        </section>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src=""></script>
        <script src=""></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
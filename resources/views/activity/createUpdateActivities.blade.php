<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>AttendanceUNA-Activities</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet">
    <!-- Fonts CSS-->
    <link rel="stylesheet" href="css/heading.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/loading.css')}}">
    <script src="js/validationDomElements.js"></script>
    <script src="js/activity/activityFunctions.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>

<body id="page-top" onload="initializerEventListenerCreateActivity()">
    <!-- Charge loading animation form -->
    <div class="loading">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
  </div>
    <!-- include general navbar blade-->
    @include('mainNavbar')

    <div class="card-body">
        <section class="page-section portfolio" id="newActivity">
            <div class="container">
                <!-- newActivity Section Heading-->
                <div class="text-center">
                    <h2 class="page-section-heading text-secondary mb-0 d-inline-block">Registro de Actividades</h2>
                </div>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                    <div class="divider-custom-line"></div>
                </div>

            </div>
        </section>
        <form id="formCreateUpdateActivity">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-6">
                
                    <input type="hidden" name="idActivity" class="form-control" id="idActivity" value="">
                    <div class="form-group" id="div-activityName">
                        <label for="activityName">Nombre de la actividad:</label>
                        <input type="text" name="activityName" class="form-control" id="activityName" aria-describedby="nameHelp" placeholder="Ingrese el nombre de la actividad" required>
                        <!-- <small id="nameHelp" class="form-text text-muted">Una pequeña descripcion de la actividad.</small> -->
                    </div>
                    <div class="form-group" id="div-activityDescription">
                        <label for="activityDescription">Descripci&oacuten de la actividad:</label>
                        <input type="text" name="activityDescription" class="form-control" id="activityDescription" placeholder="Ingrese una descripción acerca de la actividad" required>
                    </div>
                    <div class="form-group" id="div-activityManagername">
                        <label for="activityManagername">Nombre del encargado:</label>
                        <input type="text" name="activityManagername" class="form-control" id="activityManagername" placeholder="Ingrese el nombre completo" required>
                    </div>
                    <div class="form-group" id="div-activityDate">
                        <label for="activityDate">Fecha de la actividad:</label>
                        <input type="date" id="activityDate" name="activityDate" min="<?= date('Y-m-d');?>" required>
                    </div>
                        <label for="categoryActivitySelect">Categor&iacute;as para incluir en esta actividad:</label>
                        <select id="categoryActivitySelect" class="custom-select">
                            <option value="null">Seleccione...</option>
                            <option value="Administrativo">Administrativos</option>
                            <option value="Academico">Ac&aacute;demicos</option>
                            <option value="Estudiante">Estudiantes</option>
                            <option value="Invitado">Invitados</option>
                        </select>

                        <button type="button" id="btnSelectCategoryActivity" class="btn btn-secondary" onclick="addCategoryToListTb()">Agregar</button>
                        </p>
                    
                        <label for="subcategoryActivitySelect">Subcategor&iacute;as para incluir en esta actividad:</label>
                        <select id="subcategoryActivitySelect" class="custom-select">
                            <option value="null">No ha cargado datos</option>
                        </select>

                        <button type="button" id="btnSelectSubCategoryActivity" class="btn btn-secondary" onclick="addSubcategoryToListTb()">Agregar</button>
                        </p>
                   
                </div>


                <div class="col-lg-4">
                    <label for="categoriesSubcategoriesSelectedTb">Categor&iacutea(s) y subcategor&iacutea(s) inclu&iacute;das en esta actividad:</label>
                
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tbody id="categoriesSubcategoriesSelectedTb"></tbody>
                    </table>
                    </div>

                </div>
            </div>

            <div class="row justify-content-center">

                <button type="button" id="btnCreateActivity" class="btn btn-primary" onclick="validateSubmitActivity(true)"><i class="fas fa-folder-plus"></i> Guardar </button>
                <button type="button" id="btnUpdateActivity" class="btn btn-primary" onclick="validateSubmitActivity(false)" hidden=""><i class="fas fa-check-square"></i> Actualizar </button>
               
                <button type="button" class="btn btn-danger" style="margin-left: 10px" onclick="window.location.reload()" ><i class="fas fa-times fa-fw"></i>Cancelar</button>

            </div>
        </form>
        
    </div>
    <div class="row justify-content-center">
        <div class="card col-lg-10">
            <div class="card-header">
                <h6>Lista de Actividades Disponibles</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <td>Fecha</td>
                            <td>Actividad</td>
                            <td>Encargado</td>
                            <td>Acci&oacute;n</td>
                            <td>Acci&oacute;n</td>
                            </tr>
                        </thead>
                        <tbody id="table_list_activities"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
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
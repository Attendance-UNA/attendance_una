<!DOCTYPE html>
<html>
    <head>
        <script src="js/subcategory/validationDomElements.js"></script>
        <script src="js/subcategory/subcategoryFunctions.js"></script>
    </head>
    <body onload="initializerEventListener()">
        <div class="portfolio-modal modal fade" id="subcategorySectionModal0" tabindex="-1" role="dialog" aria-labelledby="#subcategorySectionModal0Label" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row justify-content-center text-center">
                                <div class="col-lg-10">
                                    <!-- subcategory Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary mb-0">Datos subcategor&iacute;as</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="container h-100">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Agregar subcategor&iacute;a</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{ url('subcategory/data') }}" enctype="multipart/form-data" id="formSubcategory">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group" id="div-name">
                                                        <input 
                                                            type="text" 
                                                            class="form-control" 
                                                            id="name" 
                                                            name="name" 
                                                            placeholder="Nombre subcategoría"
                                                        > 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group" id="div-description">
                                                        <input 
                                                            type="text" 
                                                            class="form-control" 
                                                            id="description" 
                                                            name="description" 
                                                            placeholder="Descripción subcategoría"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-primary"
                                                        onclick="return validateForm2()"
                                                    >
                                                        <i class="fas fa-check-circle"></i> Añadir
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="container h-100">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Lista de subcategor&iacute;as</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-wrapper">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripci&oacute;n</th>
                                                        <th>Acci&oacute;n</th>
                                                    </tr>
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
                                </div>
                            </div>
                            <br>
                            <div class="container">
                                <button class="btn btn-danger" href="#" data-dismiss="modal"><i class="fas fa-times fa-fw"></i>Cerrar</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
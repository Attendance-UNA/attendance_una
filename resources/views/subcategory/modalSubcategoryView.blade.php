<!DOCTYPE html>
<html>
    <head>
        <script src="js/subcategory/validationDomElements.js"></script>
        <script src="js/subcategory/subcategoryFunctions.js"></script>
    </head>
    <body>
        <!-- Charge loading animation form -->
        <div class="loading" id="loadingBySub" hidden="">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
        </div>
        <!-- Show the modal subcategory with section form and table data -->
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
                                <!-- Form subcategory space -->
                                @include('subcategory/formSubcategoryView')
                            </div>
                            <br>
                            <div class="container h-100">
                                <!-- Contains the subcategories in a table -->
                                @include('subcategory/tableSubcategoryView')
                            </div>
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
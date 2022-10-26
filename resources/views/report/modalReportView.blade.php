<!DOCTYPE html>
<html>
    <head>
        <script src="js/subcategory/validationDomElements.js"></script>
        <script src="js/report/reportFunctions.js"></script>
    </head>
    <body>
        <!-- Show the modal report -->
        <div class="portfolio-modal modal fade" id="reportSectionModal0" tabindex="-1" role="dialog" aria-labelledby="#reportSectionModal0Label" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row justify-content-center text-center">
                                <div class="col-lg-10">
                                    <!-- report Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary mb-0">Reporte de asistencias</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-circle"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- report section for generate pdf-->
                            @include('report/generateReportView')
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
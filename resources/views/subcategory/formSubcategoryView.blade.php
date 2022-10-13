<!DOCTYPE html>
<html>
    <body>
        <div class="card">
            <div id="divAddSubcategory">
                <div class="card-header">
                    <h6>Agregar subcategor&iacute;a</h6>
                </div>
            </div>
            <div id="divEditSubcategory" hidden="">
                <div class="card-header">
                    <h6>Editar subcategor&iacute;a</h6>
                </div>
            </div>
            <div class="card-body">
                <form id="formSubcategory">
                    <div class="row">
                        <input type="hidden" name="id_subcategory" id="id_subcategory">
                        <div class="col-md-4">
                            <div class="form-group" id="div-name">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name" 
                                    placeholder="Nombre subcategoría"
                                    required=""
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
                        <div id="divBtnAddSubcategory">
                            <div class="col-md">
                                <button 
                                    type="button" 
                                    class="btn btn-success"
                                    onclick="return validateSubmit(true)"
                                >
                                    <i class="fas fa-check-circle"></i> Añadir
                                </button>
                            </div>
                        </div>
                        <div id="divBtnEditSubcategory" hidden="">
                            <div class="col-md btn-group" role="group" aria-label="">
                                <button 
                                    type="button" 
                                    class="btn btn-primary"
                                    onclick="return validateSubmit(false)"
                                >
                                    <i class="fas fa-wrench"></i> Actualizar
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-danger"
                                    onclick="return cancelUpdate()"
                                >
                                    <i class="fas fa-times-circle"></i> Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
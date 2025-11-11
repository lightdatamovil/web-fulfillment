<div class="winapp" id='modulo_ajusteStock' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-list-ordered ri-30px me-2"></i>
                <h3 class="mb-0">Ajuste de stock</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-12 mb-6">
        <div class="card">
            <h4 class="card-header fw-bold pb-0">Selecciona que ajuste vas a hacer</h4>
            <div class="card-body">
                <p class="card-text">Elije una opcion</p>
                <div class="row">

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md mb-md-0 mb-5">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                        <span class="custom-option-body">
                                            <i class="ri-add-circle-line"></i>
                                            <span class="custom-option-title">Ingreso</span>
                                        </span>
                                        <input name="customRadioIcon-01" class="form-check-input ocultar" type="radio" value="" id="customRadioIcon1" checked />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md mb-md-0 mb-5">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon2">
                                        <span class="custom-option-body">
                                            <i class="ri-user-line"></i>
                                            <span class="custom-option-title">Egreso</span>
                                        </span>
                                        <input name="customRadioIcon-01" class="form-check-input ocultar" type="radio" value="" id="customRadioIcon2" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon3">
                                        <span class="custom-option-body">
                                            <i class="ri-vip-crown-line"></i>
                                            <span class="custom-option-title">Formateo</span>
                                        </span>
                                        <input name="customRadioIcon-01" class="form-check-input ocultar" type="radio" value="" id="customRadioIcon3" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-12 mb-6">
        <div class="card">
            <h4 class="card-header fw-bold pb-0">Seleccionar cliente</h4>
            <div class="card-body">
                <p class="card-text">Selecciona el cliente del cual quieres modificar su stock. Agrega fecha y observacion si asi lo deseas</p>
                <div class="row g-3 mt-3">

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-floating form-floating-outline">
                            <select id="cliente_ajusteStock" multiple class="form-select campos_ajusteStock camposObli_ajusteStock select2_ajusteStock"></select>
                            <label for="cliente_ajusteStock">Clientes</label>
                            <div class="invalid-feedback"> Debe seleccionar uno</div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-3">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control campos_ajusteStock camposObli_ajusteStock" type="date" id="fecha_ajusteStock" />
                            <label for="fecha_ajusteStock">Fecha</label>
                            <div class="invalid-feedback"> Debe completar el campo </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="observacion_ajusteStock" class="form-control campos_ajusteStock" placeholder="Observacion" />
                            <label for="observacion_ajusteStock">Observacion</label>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <div class="col-12 mb-6">
        <div class="row">

            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <h4 class="card-header fw-bold pb-0">Productos</h4>
                    <div class="card-body">
                        <p class="card-text">Selecciona un producto para ajustar su stock</p>
                        <div class="row">

                            <div class="col-12">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                                    <input
                                        type="text" class="form-control" placeholder="Buscar por nombre o SKU" />
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <div class="table-responsive text-nowrap table-container">
                                    <table class="table table-hover">

                                        <tbody id="tbodyListado_insumos">

                                            <tr>
                                                <td>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <div class="avatar-wrapper me-3">
                                                                <div class="avatar rounded-3 bg-label-secondary"><img src="../../assets/img/ecommerce-images/product-9.png" class="rounded-2"></div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <span class="text-nowrap text-heading fw-medium">Pantalon</span>
                                                                <small class="text-truncate d-none d-sm-block">SKU: 1234ABCD</small>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <small class="text-truncate d-none d-sm-block">Stock: <b>120</b></small>

                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <h4 class="card-header fw-bold pb-0">Movimientos de stock</h4>
                    <div class="card-body">
                        <p class="card-text">Selecciona un producto para ajustar su stock</p>
                        <div class="row">

                            <div class="col-12">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">

            <h4 class="card-header fw-bold pb-0">Identificadores especiales</h4>
            <button class="btn btn-label-success position-absolute" style="right: 2rem; top: 2rem;" onclick="appOffCanvasConfiguracion.open()"><span class="tf-icons ri-sound-module-line ri-19px me-2"></span>Nuevo</button>
            <div class="card-body pt-0">
                <p class="card-text">Podras agregarle diferentes campos a un producto para manejar su stock</p>
                <div class="row">

                    <div class="table-responsive text-nowrap ">
                        <table class="table table-bordered">
                            <thead class="table-thead">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyIdentificadoresEspeciales_ajusteStock">
                                <tr>
                                    <td colspan="3">
                                        <div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin identificadores especiales</span></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
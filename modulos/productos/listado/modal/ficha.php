<div class="modal fade" id="modal_mProductos" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class=" col-12 text-center mb-6">
                    <h4 class="mb-2" id="titulo_mProductos">Nuevo producto</h4>
                    <p class="mb-6" id="subtitulo_mProductos">Creacion de producto nuevo, llenar formulario.</p>
                </div>
                <div class="nav-align-top col-12 mb-6">
                    <ul id="tabs_mProductos" class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabGeneral_mProductos"
                                aria-controls="tabGeneral_mProductos"
                                aria-selected="true">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i>General</span>
                                <i class="ri-survey-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item d-none">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabCombos_mProductos"
                                aria-controls="tabCombos_mProductos"
                                aria-selected="false">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-box-3-line me-2"></i>Combos</span>
                                <i class="ri-box-3-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabCurvas_mProductos"
                                aria-controls="tabCurvas_mProductos"
                                aria-selected="false">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-palette-line me-2"></i>Curvas</span>
                                <i class="ri-palette-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabEcommerce_mProductos"
                                aria-controls="tabEcommerce_mProductos"
                                aria-selected="false">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-shopping-cart-2-line me-2"></i>E-commerce</span>
                                <i class="ri-shopping-cart-2-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabInsumos_mProductos"
                                aria-controls="tabInsumos_mProductos"
                                aria-selected="false">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-tools-line me-2"></i>Insumos</span>
                                <i class="ri-tools-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="tabGeneral_mProductos" role="tabpanel">
                        <form class="row g-5" onsubmit="return false">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="cliente_mProductos" class="form-select campos_mProductos camposObli_mProductos select2_mProductos" onchange="appModalProductos.renderEcommerce()"></select>
                                    <label for="cliente_mProductos">Cliente</label>
                                    <div class="invalid-feedback"> Debe seleccionar uno</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="nombre_mProductos" class="form-control campos_mProductos camposObli_mProductos" placeholder="Titulo" />
                                    <label for="nombre_mProductos">Titulo</label>
                                    <div class="invalid-feedback"> Debe completar el campo </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="row g-5">
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="sku_mProductos" class="form-control campos_mProductos camposObli_mProductos" placeholder="SKU" />
                                            <label for="sku_mProductos">SKU</label>
                                            <div class="invalid-feedback"> Debe completar el campo </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="ean_mProductos" class="form-control campos_mProductos camposObli_mProductos" placeholder="EAN" />
                                            <label for="ean_mProductos">EAN</label>
                                            <div class="invalid-feedback"> Debe completar el campo </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="posicion_mProductos" class="form-control campos_mProductos" placeholder="Ubicación" />
                                            <label for="posicion_mProductos">Ubicación</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <select id="esCombo_mProductos" class="form-select campos_mProductos" onchange="appModalProductos.mostrarCombos()">
                                                <option value="0" selected>No</option>
                                                <option value="1">Si</option>
                                            </select>
                                            <label for="esCombo_mProductos">¿Es combo?</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.1" min="0" id="alto_mProductos" class="form-control campos_mProductos" placeholder="Alto" oninput="appModalProductos.calcularCm3()" />
                                            <label for="alto_mProductos">Alto</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.1" min="0" id="ancho_mProductos" class="form-control campos_mProductos" placeholder="Ancho" oninput="appModalProductos.calcularCm3()" />
                                            <label for="ancho_mProductos">Ancho</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.1" min="0" id="profundo_mProductos" class="form-control campos_mProductos" placeholder="Profundidad" oninput="appModalProductos.calcularCm3()" />
                                            <label for="profundo_mProductos">Profundidad</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.1" min="0" id="cm3_mProductos" class="form-control campos_mProductos" placeholder="cm³" />
                                            <label for="cm3_mProductos">cm³</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <select id="habilitado_mProductos" class="form-select campos_mProductos">
                                                <option value="1" selected>Habilitado</option>
                                                <option value="0">Deshabilitado</option>
                                            </select>
                                            <label for="habilitado_mProductos">Estado</label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6" id="imagen_mProductos" style="height: 310px;"></div>

                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea type="text" id="descripcion_mProductos" class="form-control campos_mProductos h-px-100" placeholder="Descripción"></textarea>
                                    <label for="descripcion_mProductos">Descripción</label>
                                </div>
                            </div>


                        </form>
                    </div>

                    <div class="tab-pane fade" id="tabCombos_mProductos" role="tabpanel">
                        <div class="row">
                            <div class="col-12 bg-body mb-4 d-none d-lg-block" style="height: 44px;">

                                <div class="row h-100">
                                    <div class="col-5 h-100">
                                        <div class="d-flex align-items-center h-100 ps-3 fw-semibold">Producto</div>
                                    </div>
                                    <div class="col-6 h-100">
                                        <div class="d-flex align-items-center h-100 fw-semibold">Cantidad</div>
                                    </div>

                                    <div class="col-1 h-100 p-0">
                                        <div class="d-flex align-items-center h-100 fw-semibold"></div>
                                    </div>

                                </div>
                            </div>
                            <div class=" col-12">
                                <form class="form-repeater" id="formCombos_mProductos">
                                    <div data-repeater-list="combos">
                                        <div data-repeater-item>
                                            <div class="row g-3">
                                                <input type="hidden" name="did" id="did_combos_mProductos" />
                                                <div class="col-12 col-md-6 col-lg-8">
                                                    <select name="didProducto" id="producto_combos_mProductos" class="form-select campos_mProductos camposObli_mProductos select2_repeater_mProductos"></select>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <input type="text" name="cantidad" id="cantidad_combos_mProductos" class="form-control campos_mProductos camposObli_mProductos" placeholder="Cantidad" oninput="globalFuncionesJs.inputSoloNumeros(this)" />
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-1">
                                                    <div class="d-flex align-items-center justify-content-center h-100 ocultarDesdeVer_mProductos">
                                                        <button type="button" class="btn btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mt-3 mb-3" />
                                        </div>
                                    </div>
                                    <div class="mb-0 ocultarDesdeVer_mProductos">
                                        <button class="btn btn-outline-success" data-repeater-create>
                                            <i class="ri-add-line me-1"></i>
                                            <span class="align-middle">Nuevo producto</span>
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="tabCurvas_mProductos" role="tabpanel">
                        <div class="row g-5 align-items-baseline">

                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-floating form-floating-outline select2-primary">
                                    <select id="curvas_mProductos" class="form-select campos_mProductos select2_mProductos deshabilitarDesdeModificar_mProductos" onchange="appModalProductos.generarCurva()"></select>
                                    <label for="curvas_mProductos">Curvas</label>
                                </div>
                            </div>

                            <div id="listaValores_mProductos" style="overflow-y:auto">
                                <div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Puedes elegir una curva, caso contrario debes seleccionar la opcion "Sin curva"</span></div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="tabEcommerce_mProductos" role="tabpanel">
                        <div class="d-flex justify-content-center mb-5"><span class="badge rounded-pill bg-label-primary px-6">Asigna a cada combinacion un SKU por tienda</span></div>

                        <div style="height: 470px; overflow-y: auto;" class="table-responsive text-nowrap" id="contenedorEcommerce_mProductos"></div>
                    </div>

                    <div class="tab-pane fade" id="tabInsumos_mProductos" role="tabpanel">
                        <div class="row">
                            <div class="col-12 bg-body mb-4 d-none d-lg-block" style="height: 44px;">

                                <div class="row h-100">
                                    <div class="col-8 h-100">
                                        <div class="d-flex align-items-center h-100 ps-3 fw-semibold">Insumo</div>
                                    </div>
                                    <div class="col-3 h-100">
                                        <div class="d-flex align-items-center h-100 fw-semibold">Cantidad</div>
                                    </div>

                                    <div class="col-1 h-100 p-0">
                                        <div class="d-flex align-items-center h-100 fw-semibold"></div>
                                    </div>

                                </div>
                            </div>
                            <div class=" col-12">
                                <form class="form-repeater" id="formInsumos_mProductos">
                                    <div data-repeater-list="insumos">
                                        <div data-repeater-item>
                                            <div class="row g-3">
                                                <input type="hidden" name="did" id="did_insumos_mProductos" />

                                                <div class="col-12 col-md-6 col-lg-8">
                                                    <select name="didInsumo" id="insumo_insumos_mProductos" class="form-select campos_mProductos camposObli_mProductos select2_repeater_mProductos" onchange="appModalProductos.changeInsumo(this)"></select>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <input type="text" name="cantidad" id="cantidad_insumos_mProductos" class="form-control campos_mProductos camposObli_mProductos" placeholder="Cantidad" oninput="globalFuncionesJs.inputSoloDecimales(this)" />
                                                    <div class="mesajeCantida_mProductos d-flex align-items-centerd-flex align-items-center h-100 px-3 ocultar">
                                                        <p class="m-0">Insumo no unitario</p>
                                                    </div>

                                                </div>

                                                <div class="col-12 col-md-6 col-lg-1">
                                                    <div class="d-flex align-items-center justify-content-center h-100 ocultarDesdeVer_mProductos">
                                                        <button type="button" class="btn btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mt-3 mb-3" />
                                        </div>
                                    </div>
                                    <div class="mb-0 ocultarDesdeVer_mProductos">
                                        <button class="btn btn-outline-success" data-repeater-create>
                                            <i class="ri-add-line me-1"></i>
                                            <span class="align-middle">Nuevo insumo</span>
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 border-top pt-5 mt-2">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mProductos" onclick="appModalProductos.guardar()">Guardar</button>
                            <button type="submit" class="btn btn-success w-100" id="btnEditar_mProductos" onclick="appModalProductos.editar()">Guardar</button>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <button type="reset" class="btn btn-outline-danger w-100" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
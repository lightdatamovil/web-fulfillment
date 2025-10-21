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
                                    <select id="cliente_mProductos" class="form-select campos_mProductos camposObli_mProductos" onchange="appModalProductos.renderEcommerce()"></select>
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
                                            <input type="text" id="posicion_mProductos" class="form-control campos_mProductos" placeholder="Posicion" />
                                            <label for="posicion_mProductos">Posicion</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <select id="esCombo_mProductos" class="form-select campos_mProductos" onchange="appModalProductos.mostrarCombos(this)">
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
                                            <input type="number" step="0.1" min="0" id="profundo_mProductos" class="form-control campos_mProductos" placeholder="Profundo" oninput="appModalProductos.calcularCm3()" />
                                            <label for="profundo_mProductos">Profundo</label>
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
                                            <select id="estado_mProductos" class="form-select campos_mProductos">
                                                <option value="1" selected>Habilitado</option>
                                                <option value="0">Deshabilitado</option>
                                            </select>
                                            <label for="estado_mProductos">Estado</label>
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
                        <form class="row g-5 mb-5 align-items-center forms_mProductos" id="formCombos_mProductos" onsubmit="return false">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <select id="producto_combo_mProductos" class="form-select campos_mProductos" onchange="appModalProductos.habilitarBtnAgregarCombos()"></select>
                                    <label for="producto_combo_mProductos">Producto</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="cantidad_combo_mProductos" value="1" min="1" class="form-control campos_mProductos" placeholder="Valor" onchange="appModalProductos.habilitarBtnAgregarCombos()" onkeyup="appModalProductos.habilitarBtnAgregarCombos()" />
                                    <label for="cantidad_combo_mProductos">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-2">
                                <button id="btnAgregarCombos_mProductos" class="btn btn-label-success btnAgregar_mProductos w-100" disabled onclick="appModalProductos.agregarCombos()">Agregar</button>
                            </div>
                        </form>
                        <div id="contenedorCombos_mProductos" class="contenedoresExtras_mProductos"></div>
                    </div>




                    <div class="tab-pane fade" id="tabCurvas_mProductos" role="tabpanel">
                        <div class="row g-5 align-items-baseline">

                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-floating form-floating-outline select2-primary">
                                    <select id="curvas_mProductos" class="form-select campos_mProductos select2_mProductos" onchange="appModalProductos.generarCurva()"></select>
                                    <label for="curvas_mProductos">Curvas</label>
                                </div>
                            </div>

                            <div id="listaValores_mProductos" style="overflow-y:auto">
                                <div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Puedes elegir una curva, caso contrario debes seleccionar la opcion "Sin curva"</span></div>
                            </div>

                        </div>
                    </div>





                    <div class="tab-pane fade" id="tabEcommerce_mProductos" role="tabpanel">
                        <p class="text-muted text-center">Asigná SKUs por tienda a cada curva.</p>

                        <div id="contenedorEcommerce_mProductos" class="contenedoresExtras_mProductos"></div>
                    </div>

                    <div class="tab-pane fade" id="tabInsumos_mProductos" role="tabpanel">
                        <form class="row g-5 mb-5 align-items-center forms_mProductos" id="formInsumos_mProductos" onsubmit="return false">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <select id="nombre_insumo_mProductos" class="form-select campos_mProductos" onchange="appModalProductos.habilitarBtnAgregarInsumo()"></select>
                                    <label for="nombre_insumo_mProductos">Insumo</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.1" min="0" value="0" id="cantidad_insumo_mProductos" class="form-control campos_mProductos" placeholder="Cantidad" oninput="appModalProductos.habilitarBtnAgregarInsumo()" />
                                    <label for="cantidad_insumo_mProductos">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkInsumoHabilitado_mUsuarios" />
                                    <label class="form-check-label" for="checkInsumoHabilitado_mUsuarios">Habilitado</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-2">
                                <button id="btnAgregarInsumos_mProductos" class="btn btn-label-success btnAgregar_mProductos w-100" disabled onclick="appModalProductos.agregarInsumo()">Agregar</button>
                            </div>
                        </form>
                        <div id="contenedorInsumos_mProductos" class="contenedoresExtras_mProductos"></div>
                    </div>
                </div>

                <div class="col-12 mt-7">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mProductos" onclick="appModalProductos.guardar()">Guardar</button>
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
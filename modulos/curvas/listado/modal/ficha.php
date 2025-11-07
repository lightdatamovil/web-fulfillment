<div class="modal fade" id="modal_mCurvas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="col-12 text-center mb-6">
                    <h4 class="mb-2" id="titulo_mCurvas">Nuevo curva</h4>
                    <p class="mb-6" id="subtitulo_mCurvas">Creacion de curvas de productos, llenar formulario.</p>
                </div>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="nav-align-top col-12 mb-2">
                                <ul id="tabs_mCurvas" class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tabGeneral_mCurvas"
                                            aria-controls="tabGeneral_mCurvas"
                                            aria-selected="true">
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i>Detalle</span>
                                            <i class="ri-survey-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="tabGeneral_mCurvas" role="tabpanel">
                                    <form class="row g-5 align-items-baseline" onsubmit="return false">
                                        <h5 class="m-0 mt-3">Datos de la curva</h5>
                                        <div class="col-12 col-md-4">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="codigo_mCurvas" class="form-control campos_mCurvas camposObli_mCurvas" placeholder="Codigo" />
                                                <label for="codigo_mCurvas">Codigo</label>
                                                <div class="invalid-feedback"> Debe completar el campo </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="nombre_mCurvas" class="form-control campos_mCurvas camposObli_mCurvas" placeholder="Nombre" />
                                                <label for="nombre_mCurvas">Nombre</label>
                                                <div class="invalid-feedback"> Debe completar el campo </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3 ocultar">
                                            <div class="form-check">
                                                <input class="form-check-input campos_mCurvas" type="checkbox" value="" id="checkHabilitado_mCurvas" checked />
                                                <label class="form-check-label" for="checkHabilitado_mCurvas"> Habilitado </label>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="row g-5 mb-5 align-items-center mt-4" id="formCategorias_mCurvas" onsubmit="return false">
                                        <h5 class="m-0">Seleccionar variantes</h5>
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline select2-primary">
                                                <select id="variantes_mCurvas" class="select2_mCurvas form-select campos_mCurvas" multiple onchange="appModalCurvas.agregarVariante()"></select>
                                                <label for="variantes_mCurvas">Selecciona al menos una variante</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12" id="containerCategorias_mCurvas"></div>

                                        <div class="col-12 col-md-12 col-lg-12 ocultarDesdeVer_mCurvas ocultarDesdeModificar_mCurvas">
                                            <button id="btnGenerarCurva_mCurvas" class="btn btn-outline-success waves-effect w-100" disabled onclick="appModalCurvas.generarCurva()">
                                                <span class="tf-icons ri-sparkling-2-line ri-22px me-2"></span>Generar curva
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="nav-align-top col-12 mb-2">
                                <ul id="tabs_mCurvas" class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tabValores_mCurvas"
                                            aria-controls="tabValores_mCurvas"
                                            aria-selected="true">
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i>Tabla de valores</span>
                                            <i class="ri-survey-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0 px-3">
                                <div class="tab-pane fade show active" id="tabValores_mCurvas" role="tabpanel">
                                    <div class="row g-5 align-items-baseline">

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <input type="text" id="searchValor_mCurvas" class="form-control form-control-sm" placeholder="Buscar valor en la tabla" onkeyup="appModalCurvas.searchValor()" />
                                        </div>

                                        <div id="listaValores_mCurvas" style="overflow-y:auto">
                                            <div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-warning px-6">Sin variantes aún, agrega al menos una.</span></div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-12 border-top pt-5 mt-2">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mCurvas" onclick="appModalCurvas.guardar()">Guardar</button>
                            <button type="submit" class="btn btn-success w-100" id="btnEditar_mCurvas" onclick="appModalCurvas.editar()">Guardar</button>
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
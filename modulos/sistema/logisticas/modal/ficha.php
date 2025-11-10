<div class="modal fade" id="modal_mLogisticas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class=" col-12 text-center mb-6">
                    <h4 class="mb-2" id="titulo_mLogisticas">Nueva logistica</h4>
                    <p class="mb-6" id="subtitulo_mLogisticas">Creacion de logisticas, llenar formulario.</p>
                </div>
                <div class="nav-align-top col-12">
                    <ul id="tabs_mLogisticas" class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabGeneral_mLogisticas"
                                aria-controls="tabGeneral_mLogisticas"
                                aria-selected="true">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
                                <i class="ri-survey-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="tabGeneral_mLogisticas" role="tabpanel">
                        <div class="col-12">
                            <form class="row g-5 align-items-baseline" onsubmit="return false">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="codigo_mLogisticas" class="form-control campos_mLogisticas camposObli_mLogisticas" placeholder="Codigo" />
                                        <label for="codigo_mLogisticas">Codigo</label>
                                        <div class="invalid-feedback"> Debe completar el campo </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="nombre_mLogisticas" class="form-control campos_mLogisticas camposObli_mLogisticas" placeholder="Nombre" />
                                        <label for="nombre_mLogisticas">Nombre</label>
                                        <div class="invalid-feedback"> Debe completar el campo </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-9">
                                    <div class="input-group">

                                        <div class="form-floating form-floating-outline">
                                            <select id="sync_mLogisticas" class="form-select campos_mLogisticas" onchange="appModalLogisticas.onChangeSync(this)"></select>
                                            <label for="sync_mLogisticas">Sync</label>
                                        </div>

                                        <input type="text" id="codSync_mLogisticas" class="form-control campos_mLogisticas rounded-end" placeholder="Codigo sync" />
                                        <div class="invalid-feedback"> Debe completar el campo </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input campos_mLogisticas" type="checkbox" value="" id="checkHabilitado_mLogisticas" />
                                        <label class="form-check-label" for="checkHabilitado_mLogisticas">Habilitado</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12 p-3 border-top mt-5">
                            <div class="row">
                                <h5 class="mb-4">Direcciones</h5>
                                <div class="col-12 d-none d-lg-block mb-4" style="height: 44px;">

                                    <div class="row bg-body rounded-3 h-100">
                                        <div class="col-2 h-100">
                                            <div class="d-flex align-items-center h-100 ps-3 fw-semibold">Titulo</div>
                                        </div>
                                        <div class="col-3 h-100">
                                            <div class="d-flex align-items-center h-100 fw-semibold">Calle</div>
                                        </div>
                                        <div class="col-1 h-100">
                                            <div class="d-flex align-items-center h-100 fw-semibold">Número</div>
                                        </div>
                                        <div class="col-1 h-100">
                                            <div class="d-flex align-items-center h-100 fw-semibold">CP</div>
                                        </div>
                                        <div class="col-2 h-100">
                                            <div class="d-flex align-items-center h-100 fw-semibold">Localidad</div>
                                        </div>
                                        <div class="col-2 h-100">
                                            <div class="d-flex align-items-center h-100 fw-semibold">Provincia</div>
                                        </div>
                                        <div class="col-1 h-100 p-0">
                                            <div class="d-flex align-items-center h-100 fw-semibold"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12" style="height: 240px; overflow-y: auto; overflow-x: hidden;">
                                    <form class="form-repeater forms_mLogisticas" id="formDirecciones_mLogisticas">
                                        <div data-repeater-list="direcciones">
                                            <div data-repeater-item>
                                                <div class="row g-3">
                                                    <input type="hidden" name="did" id="did_direcciones_mLogisticas" />
                                                    <div class="col-12 col-md-6 col-lg-2">
                                                        <input type="text" name="titulo" id="titulo_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas" placeholder="Titulo" />
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-3">
                                                        <input type="text" name="calle" id="calle_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas" placeholder="Calle" />
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-1">
                                                        <input type="text" name="numero" id="numero_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas" placeholder="N°" />
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-1">
                                                        <input type="text" name="cp" id="cp_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas" placeholder="CP" />
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">
                                                        <input type="text" name="localidad" id="localidad_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas" placeholder="Localidad" />
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">
                                                        <input type="text" name="provincia" id="provincia_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas" placeholder="Provincia" />
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-1">
                                                        <div class="d-flex align-items-center justify-content-center h-100 ocultarDesdeVer_mLogisticas">
                                                            <button type="button" class="btn btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-3 mb-3" />
                                            </div>
                                        </div>
                                        <div class="mb-0 ocultarDesdeVer_mLogisticas">
                                            <button class="btn btn-outline-success" data-repeater-create>
                                                <i class="ri-add-line me-1"></i>
                                                <span class="align-middle">Nueva dirección</span>
                                            </button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-12 border-top pt-5 mt-2">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mLogisticas" onclick="appModalLogisticas.guardar()">Guardar</button>
                            <button type="submit" class="btn btn-success w-100" id="btnEditar_mLogisticas" onclick="appModalLogisticas.editar()">Guardar</button>
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
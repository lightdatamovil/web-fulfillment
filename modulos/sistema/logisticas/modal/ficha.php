<div class="modal fade" id="modal_mLogisticas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class=" col-12 text-center mb-6">
                    <h4 class="mb-2" id="titulo_mLogisticas">Nuevo logistica</h4>
                    <p class="mb-6" id="subtitulo_mLogisticas">Creacion de logisticas, llenar formulario.</p>
                </div>
                <div class="nav-align-top col-12 mb-6">
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

                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabDirecciones_mLogisticas"
                                aria-controls="tabDirecciones_mLogisticas"
                                aria-selected="false">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-map-pin-2-line me-2"></i>Direcciones</span>
                                <i class="ri-map-pin-2-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="tabGeneral_mLogisticas" role="tabpanel">
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
                                    <div class="input-group-text form-check mb-0">
                                        <input class="form-check-input m-auto campos_mLogisticas" type="checkbox" value="" id="checkEsLightdata_mLogisticas" onchange="appModalLogisticas.onChangeEsLightdata(this)" />
                                        <label class="form-check-label ms-2 lh-1" for="checkEsLightdata_mLogisticas">Es Lightdata</label>
                                    </div>
                                    <input type="text" id="codLightdata_mLogisticas" class="form-control campos_mLogisticas rounded-end" placeholder="Codigo Lightdata" />
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

                    <div class="tab-pane fade" id="tabDirecciones_mLogisticas" role="tabpanel">
                        <form class="row g-5 mb-5 align-items-center forms_mLogisticas" id="formDirecciones_mLogisticas" onsubmit="return false">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="titulo_direcciones_mLogisticas" class="form-control campos_mLogisticas camposDirecciones_mLogisticas" placeholder="Titulo" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
                                    <label for="titulo_direcciones_mLogisticas">Titulo</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="calle_direcciones_mLogisticas" class="form-control campos_mLogisticas camposDirecciones_mLogisticas" placeholder="Calle" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
                                    <label for="calle_direcciones_mLogisticas">Calle</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="numero_direcciones_mLogisticas" class="form-control campos_mLogisticas camposDirecciones_mLogisticas" placeholder="Numero" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
                                    <label for="numero_direcciones_mLogisticas">Numero</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="cp_direcciones_mLogisticas" class="form-control campos_mLogisticas camposDirecciones_mLogisticas" placeholder="CP" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
                                    <label for="cp_direcciones_mLogisticas">CP</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="localidad_direcciones_mLogisticas" class="form-control campos_mLogisticas camposDirecciones_mLogisticas" placeholder="Localidad" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
                                    <label for="localidad_direcciones_mLogisticas">Localidad</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="provincia_direcciones_mLogisticas" class="form-control campos_mLogisticas camposDirecciones_mLogisticas" placeholder="Provincia" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
                                    <label for="provincia_direcciones_mLogisticas">Provincia</label>
                                </div>
                            </div>
                            <div class="col-12  col-md-12 col-lg-10">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="observacion_direcciones_mLogisticas" class="form-control campos_mLogisticas" placeholder="Observación"></input>
                                    <label for="observacion_direcciones_mLogisticas">Observación</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-2">
                                <button id="btnAgregarDireccion_mLogisticas" class="btn btn-label-success btnAgregar_mLogisticas w-100" disabled onclick="appModalClientes.agregarDireccion()">Agregar</button>
                            </div>
                        </form>
                        <div id="contenedorDirecciones_mLogisticas" style="overflow: auto;" class="contenedoresExtras_mLogisticas"></div>
                    </div>
                </div>

                <div class="col-12 mt-7">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mLogisticas" onclick="appModalLogisticas.guardar()">Guardar</button>
                            <button type="submit" class="btn btn-success w-100" id="btnEditar_mLogisticas" onclick="appModalLogisticas.editar()">Editar</button>
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
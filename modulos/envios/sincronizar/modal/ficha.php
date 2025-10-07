<div class="modal fade" id="modal_mEnviosSincronizar" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class=" col-12 text-center mb-6">
                    <h4 class="mb-2" id="titulo_mEnviosSincronizar">Nuevo envio</h4>
                    <p class="mb-6" id="subtitulo_mEnviosSincronizar">Creacion de envios, llenar formulario.</p>
                </div>
                <div class="nav-align-top col-12 mb-6">
                    <ul id="tabs_mEnviosSincronizar" class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#tabGeneral_mEnviosSincronizar"
                                aria-controls="tabGeneral_mEnviosSincronizar"
                                aria-selected="true">
                                <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
                                <i class="ri-survey-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="tabGeneral_mEnviosSincronizar" role="tabpanel">
                        <form class="row g-5 align-items-baseline" onsubmit="return false">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="codigo_mEnviosSincronizar" class="form-control campos_mEnviosSincronizar camposObli_mEnviosSincronizar" placeholder="Codigo" />
                                    <label for="codigo_mEnviosSincronizar">Codigo</label>
                                    <div class="invalid-feedback"> Debe completar el campo </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="nombre_mEnviosSincronizar" class="form-control campos_mEnviosSincronizar camposObli_mEnviosSincronizar" placeholder="Nombre" />
                                    <label for="nombre_mEnviosSincronizar">Nombre</label>
                                    <div class="invalid-feedback"> Debe completar el campo </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input campos_mEnviosSincronizar" type="checkbox" value="" id="checkHabilitado_mEnviosSincronizar" />
                                    <label class="form-check-label" for="checkHabilitado_mEnviosSincronizar">Habilitado</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-9">
                                <div class="form-floating form-floating-outline select2-primary">
                                    <select id="clientes_mEnviosSincronizar" class="select2_mEnviosSincronizar form-select campos_mEnviosSincronizar" multiple></select>
                                    <label for="clientes_mEnviosSincronizar">Clientes</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input campos_mEnviosSincronizar" type="checkbox" value="" id="checkUnidad_mEnviosSincronizar" />
                                    <label class="form-check-label" for="checkUnidad_mEnviosSincronizar">Uso por unidad</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 mt-7">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mEnviosSincronizar" onclick="appModalEnviosSincronizar.guardar()">Guardar</button>
                            <button type="submit" class="btn btn-success w-100" id="btnEditar_mEnviosSincronizar" onclick="appModalEnviosSincronizar.editar()">Editar</button>
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
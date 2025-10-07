<div class="modal fade" id="modal_mCurvas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class=" col-12 text-center mb-6">
                    <h4 class="mb-2" id="titulo_mCurvas">Nueva curva</h4>
                    <p class="mb-6" id="subtitulo_mCurvas">Creacion de curvas, llenar formulario.</p>
                </div>
                <div class="nav-align-top col-12 mb-6">
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
                                <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
                                <i class="ri-survey-line ri-20px d-sm-none"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="tabGeneral_mCurvas" role="tabpanel">
                        <form class="row g-5 align-items-baseline" onsubmit="return false">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="codigo_mCurvas" class="form-control campos_mCurvas camposObli_mCurvas" placeholder="Codigo" />
                                    <label for="codigo_mCurvas">Codigo</label>
                                    <div class="invalid-feedback"> Debe completar el campo </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="nombre_mCurvas" class="form-control campos_mCurvas camposObli_mCurvas" placeholder="Nombre" />
                                    <label for="nombre_mCurvas">Nombre</label>
                                    <div class="invalid-feedback"> Debe completar el campo </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input campos_mCurvas" type="checkbox" value="" id="checkHabilitado_mCurvas" />
                                    <label class="form-check-label" for="checkHabilitado_mCurvas">Habilitado</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-9">
                                <div class="form-floating form-floating-outline select2-primary">
                                    <select id="clientes_mCurvas" class="select2_mCurvas form-select campos_mCurvas" multiple></select>
                                    <label for="clientes_mCurvas">Clientes</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input campos_mCurvas" type="checkbox" value="" id="checkUnidad_mCurvas" />
                                    <label class="form-check-label" for="checkUnidad_mCurvas">Uso por unidad</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 mt-7">
                    <div class="row justify-content-end g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" id="btnGuardar_mCurvas" onclick="appModalCurvas.guardar()">Guardar</button>
                            <button type="submit" class="btn btn-success w-100" id="btnEditar_mCurvas" onclick="appModalCurvas.editar()">Editar</button>
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
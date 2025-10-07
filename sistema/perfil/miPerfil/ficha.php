<div class="winapp" id='ContainerMiPerfil' style="display:none;">

    <div class="col-12 card mb-6 mt-9">
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">
            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                <img
                    src="../../assets/img/avatars/1.png"
                    alt="user image"
                    class="d-block h-auto ms-0 ms-sm-5 rounded-4 user-profile-img" />
            </div>
            <div class="flex-grow-1 mt-4 mt-sm-12">
                <div
                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-6">
                    <div class="user-profile-info">
                        <h4 class="mb-2" id="nombreSup_miPerfil"></h4>
                        <ul
                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                            <li class="list-inline-item">
                                <i class="ri-folder-user-line me-2 ri-24px"></i><span class="fw-medium" id="perfilSup_miPerfil"></span>
                            </li>
                        </ul>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-label-success" onclick="appEditarPerfil.open()">
                        <i class="ri-edit-box-line ri-16px me-2"></i>Editar perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card col-12">
        <div class="card-body row" style="min-height: 550px;">
            <div class="col-12 col-md-12 col-lg-4">
                <small class="card-text text-uppercase text-muted small">General</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-user-3-line ri-24px"></i><span class="fw-medium mx-2">Nombre:</span>
                        <span id="nombre_miPerfil"></span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-account-circle-line ri-24px"></i><span class="fw-medium mx-2">Usuario:</span>
                        <span id="usuario_miPerfil"></span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-toggle-line ri-24px"></i><span class="fw-medium mx-2">Estado:</span>
                        <span id="estado_miPerfil"></span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-id-card-line ri-24px"></i><span class="fw-medium mx-2">Perfil:</span>
                        <span id="perfil_miPerfil"></span>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-12 col-lg-4">
                <small class="card-text text-uppercase text-muted small">Contacto</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-phone-line ri-24px"></i><span class="fw-medium mx-2">Celular:</span>
                        <span id="telefono_miPerfil"></span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-mail-line ri-24px"></i><span class="fw-medium mx-2">Email:</span>
                        <span id="email_miPerfil"></span>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-12 col-lg-4">
                <small class="card-text text-uppercase text-muted small">Accesos</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-home-4-line ri-24px"></i><span class="fw-medium mx-2">Modulo inicio:</span>
                        <span id="modInicio_miPerfil"></span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-apps-2-add-line ri-24px"></i><span class="fw-medium mx-2">App:</span>
                        <span id="appHabilitada_miPerfil"></span>
                    </li>
                    <li class="d-flex align-items-center mb-4" id="containerCliente_miPerfil">
                        <i class="ri-team-line ri-24px"></i><span class="fw-medium mx-2">Codigo de cliente:</span>
                        <span id="cliente_miPerfil"></span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</div>
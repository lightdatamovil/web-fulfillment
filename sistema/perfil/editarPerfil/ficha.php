<div class="winapp" id='ContainerEditarPerfil' style="display:none;">


    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-user-settings-line ri-30px me-2"></i>
                <h3 class="mb-0">Editar mi perfil</h3>
            </div>
        </div>
    </div>

    <div class="col-12 card mb-6">
        <div class="card-body">
            <form class="row gx-5 gy-6" onsubmit="return false" autocomplete="off">
                <div class="col-12 col-md-4 col-lg-3" id="imagen_editarPerfil" style="height: 250px;"></div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="row g-5">
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nombre_editarPerfil" class="form-control campos_editarPerfil camposObli_editarPerfil" placeholder="Nombre" />
                                <label for="nombre_editarPerfil">Nombre</label>
                                <div class="invalid-feedback"> Debe completar el campo </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="apellido_editarPerfil" class="form-control campos_editarPerfil camposObli_editarPerfil" placeholder="Apellido" />
                                <label for="apellido_editarPerfil">Apellido</label>
                                <div class="invalid-feedback"> Debe completar el campo </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="usuario_editarPerfil" class="form-control campos_editarPerfil camposObli_editarPerfil" placeholder="Usuario" />
                                <label for="usuario_editarPerfil">Usuario</label>
                                <div class="invalid-feedback"> Debe completar el campo </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="email_editarPerfil" class="form-control campos_editarPerfil camposObli_editarPerfil" placeholder="Email" name="no_autofill_email" autocomplete="off" />
                                <label for="email_editarPerfil">Email</label>
                                <div class="invalid-feedback"> Debe completar el campo </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-floating form-floating-outline">
                        <select id="modInicio_editarPerfil" class="form-select campos_editarPerfil">
                            <option value="0">Clientes</option>
                            <option value="1">Productos</option>
                            <option value="2">Ordenes</option>
                        </select>
                        <label for="modInicio_editarPerfil">Modulo de inicio</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-floating form-floating-outline">
                        <input type="email" id="telefono_editarPerfil" class="form-control campos_editarPerfil" placeholder="Celular" name="no_autofill_email" autocomplete="off" />
                        <label for="telefono_editarPerfil">Celular</label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="perfil_editarPerfil" class="form-select campos_editarPerfil camposObli_editarPerfil" disabled onchange="appEditarPerfil.perfilCliente(this)"></select>
                        <label for="perfil_editarPerfil">Perfil</label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="estado_editarPerfil" class="form-select campos_editarPerfil" disabled>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="estado_editarPerfil">Estado</label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="appHabilitada_editarPerfil" class="form-select campos_editarPerfil" disabled>
                            <option value="1">Habilitada</option>
                            <option value="0">Deshabilitada</option>
                        </select>
                        <label for="appHabilitada_editarPerfil">App</label>
                    </div>
                </div>

                <div class="col-12" id="containerCliente_editarPerfil">
                    <div class="form-floating form-floating-outline select2-primary">
                        <select id="cliente_editarPerfil" class="select2modal form-select campos_editarPerfil camposObli_editarPerfil" multiple></select>
                        <label for="cliente_editarPerfil">Codigo de cliente</label>
                    </div>
                </div>

                <div class="col-12 col-md-12">
                    <div class="form-check m-0">
                        <input class="form-check-input" type="checkbox" id="checkEditPassword_editarPerfil" name="checkEditPassword_editarPerfil" onchange="appEditarPerfil.editPassword()" />
                        <label class="form-check-label" for="checkEditPassword_editarPerfil">Cambiar contraseña</label>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-3 ocultar" id="containerPassword_editarPerfil">
                    <div class="form-floating form-floating-outline">
                        <input type="password" id="password_editarPerfil" class="form-control campos_editarPerfil camposObli_editarPerfil" placeholder="Contraseña" />
                        <label for="password_editarPerfil">Nueva contraseña</label>
                        <div class="invalid-feedback"> Debe completar el campo </div>

                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 ocultar" id="containerRepPassword_editarPerfil">
                    <div class="form-floating form-floating-outline">
                        <input type="password" id="repPassword_editarPerfil" class="form-control campos_editarPerfil camposObli_editarPerfil" placeholder="Repetir contraseña" />
                        <label for="repPassword_editarPerfil">Repetir contraseña</label>
                        <div class="invalid-feedback"> Debe completar el campo </div>

                    </div>
                </div>

                <div class="col-12 mt-7">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <button type="submit" class="btn btn-success w-100" onclick="appEditarPerfil.guardar()">Guardar</button>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <button type="reset" class="btn btn-outline-danger w-100" onclick="appMiPerfil.open()">Cancelar</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="col-12 card">
        <h5 class="card-header mb-1">Eliminar cuenta</h5>
        <div class="card-body">
            <div class="mb-6 col-12 mb-0">
                <div class="alert alert-warning">
                    <h6 class="alert-heading mb-1">¿Estás seguro que quieres eliminar tu cuenta?</h6>
                    <p class="mb-0">Una vez que elimines tu cuenta, no hay vuelta atrás. Por favor, hazlo con seguridad.</p>
                </div>
            </div>
            <form id="formEliminar_editarPerfil" onsubmit="return false">
                <div class="form-check mb-6">
                    <input class="form-check-input" type="checkbox" id="checkEliminar_editarPerfil" onchange="appEditarPerfil.activarEliminar()" />
                    <label class="form-check-label" for="checkEliminar_editarPerfil">Confirmo la eliminación de mi cuenta</label>
                </div>
                <button type="submit" id="btnEliminar_editarPerfil" class="btn btn-danger deactivate-account" onclick="appEditarPerfil.eliminar()" disabled>
                    Desactivar cuenta
                </button>
            </form>
        </div>
    </div>


</div>
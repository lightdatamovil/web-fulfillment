<div class="modal fade" id="modal_mUsuarios" tabindex="-1" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mUsuarios">Nuevo usuario</h4>
					<p class="mb-6" id="subtitulo_mUsuarios">Recordá presionar <b>Guardar</b> antes de salir, así conservás todos los cambios.</p>
				</div>
				<div class="nav-align-top col-12 mb-6">
					<ul id="tabs_mUsuarios" class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<button
								type="button"
								class="nav-link active"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabGeneral_mUsuarios"
								aria-controls="tabGeneral_mUsuarios"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="tabGeneral_mUsuarios" role="tabpanel">
						<form class="row g-5 align-items-baseline" onsubmit="return false" autocomplete="off">
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="nombre_mUsuarios" class="form-control campos_mUsuarios camposObli_mUsuarios" placeholder="Nombre" />
									<label for="nombre_mUsuarios">Nombre</label>
									<div class="invalid-feedback">Debe completar el campo</div>

								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="apellido_mUsuarios" class="form-control campos_mUsuarios camposObli_mUsuarios" placeholder="Apellido" />
									<label for="apellido_mUsuarios">Apellido</label>
									<div class="invalid-feedback">Debe completar el campo</div>

								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="usuario_mUsuarios" class="form-control campos_mUsuarios camposObli_mUsuarios" placeholder="Usuario" />
									<label for="usuario_mUsuarios">Nombre de usuario</label>
									<div class="invalid-feedback">Debe completar el campo</div>

								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="email" id="email_mUsuarios" class="form-control campos_mUsuarios camposObli_mUsuarios" placeholder="Email" name="no_autofill_email" autocomplete="off" />
									<label for="email_mUsuarios">Email</label>
									<div class="invalid-feedback">Debe completar el campo</div>

								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-5">
								<div class="form-floating form-floating-outline">
									<input type="text" id="telefono_mUsuarios" class="form-control campos_mUsuarios" placeholder="Telefono" />
									<label for="telefono_mUsuarios">Telefono</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-5">
								<div class="form-floating form-floating-outline">
									<select id="perfil_mUsuarios" class="form-select campos_mUsuarios camposObli_mUsuarios" onchange="appModalUsuarios.perfilCliente(this)"></select>
									<label for="perfil_mUsuarios">Perfil</label>
									<div class="invalid-feedback">Debe seleccionar uno</div>
								</div>
							</div>

							<div class="col-12 col-md-12 col-lg-2">
								<div class="form-check mt-4">
									<input class="form-check-input campos_mUsuarios" type="checkbox" id="estado_mUsuarios" />
									<label class="form-check-label" for="estado_mUsuarios">Habilitado</label>
								</div>
							</div>

							<div class="col-12 col-md-12 ocultar" id="containerEditPassword_mUsuarios">
								<div class="form-check mt-4">
									<input class="form-check-input campos_mUsuarios" type="checkbox" id="checkEditPassword_mUsuarios" onchange="appModalUsuarios.editPassword()" />
									<label class="form-check-label" for="checkEditPassword_mUsuarios">Modificar contraseña</label>
								</div>
							</div>

							<div class="col-12 col-md-12 col-lg-6" id="containerPassword_mUsuarios">
								<div class="form-floating form-floating-outline">
									<input type="password" id="password_mUsuarios" class="form-control campos_mUsuarios camposObli_mUsuarios" placeholder="Contraseña" />
									<label for="password_mUsuarios">Nueva contraseña</label>
									<div class="invalid-feedback">Debe completar el campo</div>

								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6" id="containerRepPassword_mUsuarios">
								<div class="form-floating form-floating-outline">
									<input type="password" id="repPassword_mUsuarios" class="form-control campos_mUsuarios camposObli_mUsuarios" placeholder="Repetir contraseña" />
									<label for="repPassword_mUsuarios">Repetir contraseña</label>
									<div class="invalid-feedback">Debe completar el campo</div>

								</div>
							</div>

							<h5 class="mt-6 mb-0 border-top pt-4 ms-1">Accesos</h5>

							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<select id="modInicio_mUsuarios" class="form-select campos_mUsuarios">
										<option value="1">Home</option>
									</select>
									<label for="modInicio_mUsuarios">Modulo de inicio</label>
								</div>
							</div>

							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-check">
									<input class="form-check-input campos_mUsuarios" type="checkbox" value="" id="appHabilitada_mUsuarios" />
									<label class="form-check-label" for="appHabilitada_mUsuarios">App habilitada</label>
								</div>
							</div>


							<div class="col-12" id="containerCliente_mUsuarios">
								<div class="form-floating form-floating-outline select2-primary">
									<select id="cliente_mUsuarios" class="select2_mUsuarios form-select campos_mUsuarios camposObli_mUsuarios" multiple></select>
									<label for="cliente_mUsuarios">Codigo de cliente</label>
									<div class="invalid-feedback"> Debe completar el campo </div>
								</div>
							</div>

						</form>
					</div>

				</div>

				<div class="col-12 border-top pt-5 mt-2">
					<div class="row justify-content-end g-3">
						<div class="col-12 col-md-6 col-lg-3">
							<button type="submit" class="btn btn-success w-100" id="btnGuardar_mUsuarios" onclick="appModalUsuarios.guardar()">Guardar</button>
							<button type="submit" class="btn btn-success w-100" id="btnEditar_mUsuarios" onclick="appModalUsuarios.editar()">Guardar</button>
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
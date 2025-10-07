<div class="modal fade" id="modal_mClientes" tabindex="-1" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mClientes">Nuevo cliente</h4>
					<p class="mb-6" id="subtitulo_mClientes">Creacion de cliente nuevo, llenar formulario.</p>
				</div>
				<div class="nav-align-top col-12 mb-6">
					<ul id="tabs_mClientes" class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<button
								type="button"
								class="nav-link active"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabGeneral_mClientes"
								aria-controls="tabGeneral_mClientes"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i>Datos Generales</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
						<li class="nav-item">
							<button
								type="button"
								class="nav-link"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabCuentas_mClientes"
								aria-controls="tabCuentas_mClientes"
								aria-selected="false">
								<span class="d-none d-sm-block"><i class="tf-icons ri-key-2-line me-2"></i>Cuentas</span>
								<i class="ri-key-2-line ri-20px d-sm-none"></i>
							</button>
						</li>
						<li class="nav-item">
							<button
								type="button"
								class="nav-link"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabDirecciones_mClientes"
								aria-controls="tabDirecciones_mClientes"
								aria-selected="false">
								<span class="d-none d-sm-block"><i class="tf-icons ri-map-pin-2-line me-2"></i>Direcciones</span>
								<i class="ri-map-pin-2-line ri-20px d-sm-none"></i>
							</button>
						</li>
						<li class="nav-item">
							<button
								type="button"
								class="nav-link"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabContactos_mClientes"
								aria-controls="tabContactos_mClientes"
								aria-selected="false">
								<span class="d-none d-sm-block"><i class="tf-icons ri-phone-line me-2"></i>Contactos</span>
								<i class="ri-phone-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="tabGeneral_mClientes" role="tabpanel">
						<form class="row g-5" onsubmit="return false">
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="codigo_mClientes" class="form-control campos_mClientes camposObli_mClientes" placeholder="Código" />
									<label for="codigo_mClientes">Código</label>
									<div class="invalid-feedback"> Debe completar el campo </div>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="razonSocial_mClientes" class="form-control campos_mClientes camposObli_mClientes" placeholder="Razón social" />
									<label for="razonSocial_mClientes">Razón social</label>
									<div class="invalid-feedback"> Debe completar el campo </div>

								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<input type="text" id="nombreFantasia_mClientes" class="form-control campos_mClientes camposObli_mClientes" placeholder="Nombre fantasia" />
									<label for="nombreFantasia_mClientes">Nombre fantasia</label>
									<div class="invalid-feedback"> Debe completar el campo </div>

								</div>
							</div>

							<div class="col-12 col-md-12 col-lg-6">
								<div class="form-floating form-floating-outline">
									<select id="estado_mClientes" class="form-select campos_mClientes">
										<option value="1" selected>Habilitado</option>
										<option value="0">Deshabilitado</option>
									</select>
									<label for="estado_mClientes">Estado</label>
								</div>
							</div>
							<div class="col-12 col-md-12">
								<div class="form-floating form-floating-outline">
									<textarea type="text" id="observacion_mClientes" class="form-control campos_mClientes h-px-100" placeholder="Observaciones internas"></textarea>
									<label for="observacion_mClientes">Observaciones internas</label>
								</div>
							</div>
						</form>
					</div>

					<div class="tab-pane fade" id="tabCuentas_mClientes" role="tabpanel">
						<form class="row g-5 mb-5 align-items-center forms_mClientes" id="formTiendas_mClientes" onsubmit="return false">
							<div class="col-12 col-md-12 col-lg-9">
								<div class="form-floating form-floating-outline">
									<select id="tienda_mClientes" class="form-select campos_mClientes" onchange="appModalClientes.habilitarBtnAgregarTienda()"></select>
									<label for="tienda_mClientes">Tienda</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-3">
								<button style="width: 100%;" id="btnAgregarTienda_mClientes" class="btn btn-label-success btnAgregar_mClientes w-100" disabled onclick="appModalClientes.renderTienda()">Agregar</button>
							</div>
						</form>
						<div id="contenedorTiendas_mClientes" class="row g-3 contenedoresExtras_mClientes" style="overflow: auto;"></div>
					</div>

					<div class="tab-pane fade" id="tabDirecciones_mClientes" role="tabpanel">
						<div class="row">
							<div class="col-12 bg-body mb-4 d-none d-lg-block" style="height: 44px;">

								<div class="row h-100">
									<div class="col-2 h-100">
										<div class="d-flex align-items-center h-100 ps-3 fw-semibold">Titulo</div>
									</div>
									<div class="col-2 h-100">
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
									<div class="col-1 h-100">
										<div class="d-flex align-items-center h-100 fw-semibold">Provincia</div>
									</div>
									<div class="col-2 h-100">
										<div class="d-flex align-items-center h-100 fw-semibold">Observación</div>
									</div>
									<div class="col-1 h-100 p-0">
										<div class="d-flex align-items-center h-100 fw-semibold">Acciones</div>
									</div>

								</div>
							</div>
							<div class=" col-12">
								<form class="form-repeater">
									<div data-repeater-list="group-a">
										<div data-repeater-item>
											<div class="row g-3">
												<div class="col-12 col-md-6 col-lg-2">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="Titulo" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-2">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="Calle" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-1">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="N°" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-1">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="CP" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-2">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="Localidad" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-1">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="Provincia" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-2">
													<div>
														<input
															type="text"
															id="form-repeater-1-1"
															class="form-control form-control-sm"
															placeholder="Observación" />
													</div>
												</div>
												<div class="col-12 col-md-6 col-lg-1">
													<div class="d-flex align-items-center justify-content-center h-100">
														<button type="button" class="btn btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>

													</div>

												</div>



												<!-- <div class="mb-6 col-lg-6 col-xl-3 col-12 mb-0">
													<div class="form-floating form-floating-outline">
														<input
															type="password"
															id="form-repeater-1-2"
															class="form-control"
															placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
														<label for="form-repeater-1-2">Password</label>
													</div>
												</div>
												<div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
													<div class="form-floating form-floating-outline">
														<select id="form-repeater-1-3" class="form-select">
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
														<label for="form-repeater-1-3">Gender</label>
													</div>
												</div>
												<div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
													<div class="form-floating form-floating-outline">
														<select id="form-repeater-1-4" class="form-select">
															<option value="Designer">Designer</option>
															<option value="Developer">Developer</option>
															<option value="Tester">Tester</option>
															<option value="Manager">Manager</option>
														</select>
														<label for="form-repeater-1-4">Profession</label>
													</div>
												</div> -->

											</div>
											<hr class="mt-3 mb-3" />
										</div>
									</div>
									<div class="mb-0">
										<button class="btn btn-primary" data-repeater-create>
											<i class="ri-add-line me-1"></i>
											<span class="align-middle">Add</span>
										</button>
									</div>
								</form>
							</div>

						</div>
						<!-- <form class="row g-5 mb-5 align-items-center forms_mClientes" id="formDirecciones_mClientes" onsubmit="return false">
							<div class="col-12 col-md-12 col-lg-4">
								<div class="form-floating form-floating-outline">
									<input type="text" id="titulo_direcciones_mClientes" class="form-control campos_mClientes camposDirecciones_mClientes" placeholder="Titulo" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
									<label for="titulo_direcciones_mClientes">Titulo</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-4">
								<div class="form-floating form-floating-outline">
									<input type="text" id="calle_direcciones_mClientes" class="form-control campos_mClientes camposDirecciones_mClientes" placeholder="Calle" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
									<label for="calle_direcciones_mClientes">Calle</label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-2">
								<div class="form-floating form-floating-outline">
									<input type="text" id="numero_direcciones_mClientes" class="form-control campos_mClientes camposDirecciones_mClientes" placeholder="Numero" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
									<label for="numero_direcciones_mClientes">Numero</label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-2">
								<div class="form-floating form-floating-outline">
									<input type="text" id="cp_direcciones_mClientes" class="form-control campos_mClientes camposDirecciones_mClientes" placeholder="CP" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
									<label for="cp_direcciones_mClientes">CP</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-3">
								<div class="form-floating form-floating-outline">
									<input type="text" id="localidad_direcciones_mClientes" class="form-control campos_mClientes camposDirecciones_mClientes" placeholder="Localidad" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
									<label for="localidad_direcciones_mClientes">Localidad</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-3">
								<div class="form-floating form-floating-outline">
									<input type="text" id="provincia_direcciones_mClientes" class="form-control campos_mClientes camposDirecciones_mClientes" placeholder="Provincia" onkeyup="appModalClientes.habilitarBtnAgregarDireccion()" />
									<label for="provincia_direcciones_mClientes">Provincia</label>
								</div>
							</div>
							<div class="col-12  col-md-12 col-lg-4">
								<div class="form-floating form-floating-outline">
									<input type="text" id="observacion_direcciones_mClientes" class="form-control campos_mClientes" placeholder="Observación"></input>
									<label for="observacion_direcciones_mClientes">Observación</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-2">
								<button id="btnAgregarDireccion_mClientes" class="btn btn-label-success btnAgregar_mClientes w-100" disabled onclick="appModalClientes.agregarDireccion()">Agregar</button>
							</div>
						</form>
						<div id="contenedorDirecciones_mClientes" style="overflow: auto;" class="contenedoresExtras_mClientes"></div> -->
					</div>

					<div class="tab-pane fade" id="tabContactos_mClientes" role="tabpanel">
						<form class="row g-5 mb-5 align-items-center forms_mClientes" id="formContactos_mClientes" onsubmit="return false">
							<div class="col-12 col-md-12 col-lg-5">
								<div class="form-floating form-floating-outline">
									<select id="tipo_contacto_mClientes" class="form-select campos_mClientes camposContactos_mClientes" onchange="appModalClientes.habilitarBtnAgregarContacto()"></select>
									<label for="tipo_contacto_mClientes">Tipo de contacto</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-5">
								<div class="form-floating form-floating-outline">
									<input type="text" id="valor_contacto_mClientes" class="form-control campos_mClientes camposContactos_mClientes" placeholder="Valor" onkeyup="appModalClientes.habilitarBtnAgregarContacto()" />
									<label for="valor_contacto_mClientes">Valor</label>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-2">
								<button id="btnAgregarContacto_mClientes" class="btn btn-label-success btnAgregar_mClientes w-100" disabled onclick="appModalClientes.agregarContacto()">Agregar</button>
							</div>
						</form>
						<div id="contenedorContactos_mClientes" class="contenedoresExtras_mClientes" style="overflow: auto;"></div>
					</div>

				</div>

				<div class="col-12 mt-7">
					<div class="row justify-content-end g-3">
						<div class="col-12 col-md-6 col-lg-3">
							<button type="submit" class="btn btn-success w-100" id="btnGuardar_mClientes" onclick="appModalClientes.guardar()">Guardar</button>
							<button type="submit" class="btn btn-success w-100" id="btnEditar_mClientes" onclick="appModalClientes.editar()">Modificar</button>

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
<div class="modal fade" id="modal_mVariantes" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div class="col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mVariantes">Nuevo variante</h4>
					<p class="mb-6" id="subtitulo_mVariantes">Creacion de variantes de productos, llenar formulario.</p>
				</div>

				<div class="col-12">
					<div class="row">

						<div class="col-12 col-md-12 col-lg-6">
							<div class="nav-align-top col-12 mb-2">
								<ul id="tabs_mVariantes" class="nav nav-tabs nav-fill" role="tablist">
									<li class="nav-item">
										<button
											type="button"
											class="nav-link active"
											role="tab"
											data-bs-toggle="tab"
											data-bs-target="#tabGeneral_mVariantes"
											aria-controls="tabGeneral_mVariantes"
											aria-selected="true">
											<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> Variante</span>
											<i class="ri-survey-line ri-20px d-sm-none"></i>
										</button>
									</li>
								</ul>
							</div>

							<div class="tab-content p-0">
								<div class="tab-pane fade show active" id="tabGeneral_mVariantes" role="tabpanel">
									<form class="row g-5" onsubmit="return false">
										<div class="col-12 col-md-4">
											<div class="form-floating form-floating-outline">
												<input type="text" id="codigo_mVariantes" class="form-control campos_mVariantes camposObli_mVariantes" placeholder="Codigo" />
												<label for="codigo_mVariantes">Codigo</label>
												<div class="invalid-feedback"> Debe completar el campo </div>
											</div>
										</div>
										<div class="col-12 col-md-8">
											<div class="form-floating form-floating-outline">
												<input type="text" id="nombre_mVariantes" class="form-control campos_mVariantes camposObli_mVariantes" placeholder="Nombre" />
												<label for="nombre_mVariantes">Nombre</label>
												<div class="invalid-feedback"> Debe completar el campo </div>
											</div>
										</div>

										<div class="col-12 col-md-12">
											<div class="form-check">
												<input class="form-check-input campos_mVariantes" type="checkbox" value="" id="checkHabilitado_mVariantes" checked />
												<label class="form-check-label" for="checkHabilitado_mVariantes"> Habilitado </label>
											</div>
										</div>
									</form>
									<form class="row g-5 mb-5 align-items-center pt-3 border-top mt-5" id="formCategorias_mVariantes" onsubmit="return false">
										<h5 class="m-0">Categorias</h5>
										<div class="col-12 col-md-12 col-lg-8">
											<div class="form-floating form-floating-outline">
												<input type="text" id="categoria_mVariantes" class="form-control campos_mVariantes" placeholder="categoria" onkeyup="appModalVariantes.habilitarBtnAgregar()" />
												<label for="categoria_mVariantes">Nueva categoria</label>
											</div>
										</div>

										<div class="col-12 col-md-12 col-lg-4">
											<button id="btnAgregarCategoria_mVariantes" class="btn btn-label-success w-100" disabled onclick="appModalVariantes.agregarCategoria()">Agregar</button>
										</div>
									</form>
									<div id="listaCategorias_mVariantes"></div>
								</div>
							</div>
						</div>


						<div class="col-12 col-md-12 col-lg-6">
							<div class="nav-align-top col-12 mb-2">
								<ul id="tabs_mVariantes" class="nav nav-tabs nav-fill" role="tablist">
									<li class="nav-item">
										<button
											type="button"
											class="nav-link active"
											role="tab"
											data-bs-toggle="tab"
											data-bs-target="#tabGeneral_mVariantes"
											aria-controls="tabGeneral_mVariantes"
											aria-selected="true">
											<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
											<i class="ri-survey-line ri-20px d-sm-none"></i>
										</button>
									</li>
								</ul>
							</div>

							<div class="tab-content p-0">
								<div class="tab-pane fade show active" id="tabGeneral_mVariantes" role="tabpanel">

									<div class="col-12 px-3">
										<div class="row">

											<div class="col-12 d-none d-lg-block mb-4" style="height: 44px;">

												<div class="row bg-body rounded-3 h-100">
													<div class="col-5 h-100">
														<div class="d-flex align-items-center h-100 ps-3 fw-semibold">Titulo</div>
													</div>
													<div class="col-5 h-100">
														<div class="d-flex align-items-center h-100 fw-semibold">Calle</div>
													</div>
													<div class="col-2 h-100 p-0">
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
																<div class="col-12 col-md-6 col-lg-5">
																	<input type="text" name="localidad" id="localidad_direcciones_mLogisticas" class="form-control form-control-sm campos_mLogisticas camposObli_mLogisticas campos_direcciones_mLogisticas" placeholder="Localidad" />
																</div>
																<div class="col-12 col-md-6 col-lg-5">
																	<select name="tipo" id="tipo_contactos_mClientes" class="form-select form-select-sm campos_mClientes camposObli_mClientes campos_contactos_mClientes"></select>
																</div>
																<div class="col-12 col-md-6 col-lg-2">
																	<div class="d-flex align-items-center justify-content-center h-100">
																		<button type="button" class="btn btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>
																	</div>
																</div>
															</div>
															<hr class="mt-3 mb-3" />
														</div>
													</div>
													<div class="mb-0">
														<button class="btn btn-icon btn-outline-success" data-repeater-create>
															<span class="tf-icons ri-add-line ri-22px"></span>
														</button>

													</div>
												</form>

											</div>

										</div>
									</div>

								</div>
							</div>
						</div>


					</div>
				</div>

				<div class="col-12 mt-7">
					<div class="row justify-content-end g-3">
						<div class="col-12 col-md-6 col-lg-3">
							<button type="submit" class="btn btn-success w-100" id="btnGuardar_mVariantes" onclick="appModalVariantes.guardar()">Guardar</button>
							<button type="submit" class="btn btn-success w-100" id="btnEditar_mVariantes" onclick="appModalVariantes.editar()">Guardar</button>
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
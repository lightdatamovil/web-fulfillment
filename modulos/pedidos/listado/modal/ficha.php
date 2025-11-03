<div class="modal fade" id="modal_mPedidos" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mPedidos">Nuevo pedido</h4>
					<p class="mb-6" id="subtitulo_mPedidos">Creacion de pedidos, llenar formulario.</p>
				</div>
				<div class="nav-align-top col-12">
					<ul id="tabs_mPedidos" class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<button
								type="button"
								class="nav-link active"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabGeneral_mPedidos"
								aria-controls="tabGeneral_mPedidos"
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
								data-bs-target="#tabProductos_mPedidos"
								aria-controls="tabProductos_mPedidos"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> Productos</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
						<li class="nav-item">
							<button
								type="button"
								class="nav-link"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabDireccion_mPedidos"
								aria-controls="tabDireccion_mPedidos"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> Direccion</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="tabGeneral_mPedidos" role="tabpanel">
						<div class="col-12">
							<form class="row g-5 align-items-baseline" onsubmit="return false">

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input class="form-control campos_mPedidos camposObli_mPedidos" type="date" id="fechaVenta_mPedidos" />
										<label for="fechaVenta_mPedidos">Fecha venta</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<select id="cliente_mPedidos" class="form-select campos_mPedidos camposObli_mPedidos select2_mPedidos"></select>
										<label for="cliente_mPedidos">Cliente</label>
										<div class="invalid-feedback"> Debe seleccionar uno</div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-4">
									<div class="form-floating form-floating-outline">
										<input type="text" id="idVenta_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="ID Venta" />
										<label for="idVenta_mPedidos">ID Venta</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-4">
									<div class="input-group">
										<span class="input-group-text">$</span>
										<input type="text" id="total_mPedidos" class="form-control rounded-end campos_mPedidos camposObli_mPedidos" placeholder="Total" oninput="globalFuncionesJs.inputSoloNumeros(this)" />
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-4">
									<div class="form-floating form-floating-outline">
										<input class="form-control campos_mPedidos" type="date" id="deadline_mPedidos" />
										<label for="deadline_mPedidos">Deadline</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12">
									<div class="form-floating form-floating-outline">
										<textarea type="text" id="observacion_mPedidos" class="form-control campos_mPedidos h-px-100" placeholder="Observacion"></textarea>
										<label for="observacion_mPedidos">Observacion</label>
									</div>
								</div>

							</form>
							<form class="row g-5 align-items-baseline border-top mt-5" onsubmit="return false">
								<h5 class="mb-0 mt-3">Comprador</h5>
								<div class="col-12 col-md-12 col-lg-4">
									<div class="form-floating form-floating-outline">
										<input type="text" id="comprador_nombre_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="Comprador" />
										<label for="comprador_nombre_mPedidos">Nombre</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-4">
									<div class="form-floating form-floating-outline">
										<input type="text" id="comprador_telefono_mPedidos" class="form-control campos_mPedidos" placeholder="Comprador" oninput="globalFuncionesJs.inputSoloNumeros(this)" />
										<label for="comprador_telefono_mPedidos">Telefono</label>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-4">
									<div class="form-floating form-floating-outline">
										<input type="text" id="comprador_email_mPedidos" class="form-control campos_mPedidos camposVerif_mPedidos" placeholder="Comprador" />
										<label for="comprador_email_mPedidos">Email</label>
										<div class="invalid-feedback">Ingrese un email válido</div>
									</div>
								</div>

							</form>
						</div>


					</div>

					<div class="tab-pane fade" id="tabProductos_mPedidos" role="tabpanel">
						<div class="row">
							<div class="col-12 bg-body mb-4 d-none d-lg-block ocultarDesdeVer_mPedidos" style="height: 44px;">

								<div class="row bg-body rounded-3 h-100">
									<div class="col-3 h-100">
										<div class="d-flex align-items-center h-100 ps-3 fw-semibold">Producto</div>
									</div>
									<div class="col-6 h-100">
										<div class="d-flex align-items-center h-100 fw-semibold">Valores</div>
									</div>
									<div class="col-2 h-100">
										<div class="d-flex align-items-center h-100 fw-semibold">Cantidad</div>
									</div>

									<div class="col-1 h-100 p-0">
										<div class="d-flex align-items-center h-100 fw-semibold"></div>
									</div>

								</div>
							</div>
							<div class="col-12 ocultarDesdeVer_mPedidos">
								<form class="form-repeater" id="formProductos_mPedidos">
									<div data-repeater-list="productos">
										<div data-repeater-item>
											<div class="row g-3">
												<input type="hidden" name="did" id="did_productos_mPedidos" />
												<div class="col-12 col-md-6 col-lg-3">
													<select name="did_producto" id="producto_productos_mPedidos" class="form-select campos_mPedidos camposObli_mPedidos select2_repeater_mPedidos producto_productos_mPedidos" onchange="appModalPedidos.renderVariantes(this)"></select>
												</div>

												<div class="col-12 col-md-6 col-lg-6">
													<select name="did_producto_variante_valor" id="variantes_productos_mPedidos" class="form-select camposObli_mPedidos select2_repeater_mPedidos variantes_productos_mPedidos" disabled>
														<option value="">Selecciona el producto para ver</option>
													</select>
												</div>

												<div class="col-12 col-md-6 col-lg-2">
													<input type="text" name="cantidad" id="cantidad_productos_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="Cantidad" oninput="globalFuncionesJs.inputSoloNumeros(this)" />
												</div>
												<div class="col-12 col-md-6 col-lg-1">
													<div class="d-flex align-items-center justify-content-center h-100 ocultarDesdeVer_mPedidos">
														<button type="button" class="btn btn-icon rounded-pill btn-text-danger" data-repeater-delete data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="tf-icons ri-delete-bin-6-line ri-22px"></i></button>
													</div>
												</div>
											</div>
											<hr class="mt-3 mb-3" />
										</div>
									</div>
									<div class="mb-0 ocultarDesdeVer_mPedidos">
										<button class="btn btn-outline-success" data-repeater-create>
											<i class="ri-add-line me-1"></i>
											<span class="align-middle">Nuevo producto</span>
										</button>
									</div>
								</form>

							</div>

							<div id="listaProductos_mPedidos" class="ocultar" style="overflow-y:auto"></div>
						</div>

					</div>

					<div class="tab-pane fade" id="tabDireccion_mPedidos" role="tabpanel">
						<div class="col-12">
							<form class="row g-5 align-items-baseline" onsubmit="return false">

								<div class="col-12 col-md-12 col-lg-12">
									<div class="form-floating form-floating-outline">
										<input type="text" id="calle_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="Calle" />
										<label for="calle_mPedidos">Calle</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input type="text" id="numero_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="N°" />
										<label for="numero_mPedidos">N°</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input type="text" id="cp_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="CP" />
										<label for="cp_mPedidos">CP</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input type="text" id="localidad_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="Localidad" />
										<label for="localidad_mPedidos">Localidad</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input type="text" id="provincia_mPedidos" class="form-control campos_mPedidos camposObli_mPedidos" placeholder="Provincia" />
										<label for="provincia_mPedidos">Provincia</label>
										<div class="invalid-feedback"> Debe completar el campo </div>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input type="text" id="latitud_mPedidos" class="form-control campos_mPedidos" placeholder="Latitud" />
										<label for="latitud_mPedidos">Latitud</label>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="form-floating form-floating-outline">
										<input type="text" id="longitud_mPedidos" class="form-control campos_mPedidos" placeholder="Longitud" />
										<label for="longitud_mPedidos">Longitud</label>
									</div>
								</div>

								<div class="col-12 col-md-12 col-lg-12">
									<div class="form-floating form-floating-outline">
										<input type="text" id="referencia_mPedidos" class="form-control campos_mPedidos" placeholder="Referencia" />
										<label for="referencia_mPedidos">Referencia</label>
									</div>
								</div>

							</form>
						</div>

					</div>
				</div>

				<div class="col-12 border-top pt-5 mt-2">
					<div class="row justify-content-end g-3">
						<div class="col-12 col-md-6 col-lg-3">
							<button type="submit" class="btn btn-success w-100" id="btnGuardar_mPedidos" onclick="appModalPedidos.guardar()">Guardar</button>
							<button type="submit" class="btn btn-success w-100" id="btnEditar_mPedidos" onclick="appModalPedidos.editar()">Guardar</button>
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
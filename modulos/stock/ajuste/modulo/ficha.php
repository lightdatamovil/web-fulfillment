<div class="winapp" id='modulo_ajusteStock' style="display:none;">

	<div class="col-12">
		<div id="steps_ajusteStock" class="bs-stepper wizard-modern linear">

			<div class="card mb-6">
				<div class="card-body border-bottom">
					<div class="d-flex align-items-center">
						<i class="ri-list-ordered ri-30px me-2"></i>
						<h3 class="mb-0">Ajuste de stock</h3>
					</div>
				</div>
				<div class="bs-stepper-header">
					<div class="step" data-target="#step1_ajusteStock">
						<button type="button" class="step-trigger">
							<span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
							<span class="bs-stepper-label">
								<span class="bs-stepper-number">01</span>
								<span class="d-flex flex-column gap-1 ms-2">
									<span class="bs-stepper-title">Selecciona el ajuste</span>
								</span>
							</span>
						</button>
					</div>
					<div class="line"></div>

					<div class="step" data-target="#step2_ajusteStock">
						<button type="button" class="step-trigger">
							<span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
							<span class="bs-stepper-label">
								<span class="bs-stepper-number">02</span>
								<span class="d-flex flex-column gap-1 ms-2">
									<span class="bs-stepper-title">Seleccionar productos</span>
								</span>
							</span>
						</button>
					</div>

				</div>

			</div>

			<div class="bs-stepper-content bg-transparent shadow-none p-0">
				<form onSubmit="return false" class="h-100">

					<div id="step1_ajusteStock" class="content">

						<div class="col-12 mb-6">
							<div class="card">

								<h4 class="card-header fw-bold pb-0">Selecciona el ajuste que harás al stock de los productos</h4>
								<div class="card-body">
									<p class="card-text">Elige una opción</p>
									<div class="row g-5">

										<div class="col-12 border-bottom pb-5">
											<div class="row">
												<div class="col-md mb-md-0 mb-5">
													<div class="form-check custom-option custom-option-icon">
														<label class="form-check-label custom-option-content" for="opcionIngreso_ajusteStock">
															<span class="custom-option-body">
																<i class="ri-add-circle-line"></i>
																<span class="custom-option-title">Ingreso</span>
															</span>
															<input name="opcionAjuste_ajusteStock" class="form-check-input ocultar" type="radio" value="1" id="opcionIngreso_ajusteStock" checked />
														</label>
													</div>
												</div>
												<div class="col-md mb-md-0 mb-5">
													<div class="form-check custom-option custom-option-icon">
														<label class="form-check-label custom-option-content" for="opcionEgreso_ajusteStock">
															<span class="custom-option-body">
																<i class="ri-indeterminate-circle-line"></i>
																<span class="custom-option-title">Egreso</span>
															</span>
															<input name="opcionAjuste_ajusteStock" class="form-check-input ocultar" type="radio" value="2" id="opcionEgreso_ajusteStock" />
														</label>
													</div>
												</div>
												<div class="col-md">
													<div class="form-check custom-option custom-option-icon">
														<label class="form-check-label custom-option-content" for="opcionFormateo_ajusteStock">
															<span class="custom-option-body">
																<i class="ri-error-warning-line"></i>
																<span class="custom-option-title">Formateo</span>
															</span>
															<input name="opcionAjuste_ajusteStock" class="form-check-input ocultar" type="radio" value="3" id="opcionFormateo_ajusteStock" />
														</label>
													</div>
												</div>
											</div>
										</div>

										<div class="col-12">
											<h4 class="card-header fw-bold p-0">Selecciona un cliente y fecha de carga</h4>
											<p class="card-text">La obsevacion es opcional</p>

											<div class="row g-3 mt-3">

												<div class="col-12 col-md-6 col-lg-3">
													<div class="form-floating form-floating-outline">
														<select id="cliente_ajusteStock" class="form-select campos_ajusteStock camposObliStep1_ajusteStock select2_ajusteStock"></select>
														<label for="cliente_ajusteStock">Clientes</label>
														<div class="invalid-feedback"> Debe seleccionar uno</div>
													</div>
												</div>

												<div class="col-12 col-md-12 col-lg-3">
													<div class="form-floating form-floating-outline">
														<input class="form-control campos_ajusteStock camposObliStep1_ajusteStock" type="date" id="fecha_ajusteStock" />
														<label for="fecha_ajusteStock">Fecha</label>
														<div class="invalid-feedback"> Debe completar el campo </div>
													</div>
												</div>

												<div class="col-12 col-md-12 col-lg-6">
													<div class="form-floating form-floating-outline">
														<input type="text" id="observacion_ajusteStock" class="form-control campos_ajusteStock" placeholder="Observacion" />
														<label for="observacion_ajusteStock">Observacion</label>
													</div>
												</div>

											</div>
										</div>

									</div>
								</div>
							</div>

						</div>

						<div class="card p-5">
							<div class="col-12">
								<div class="row h-100 align-items-end">
									<div class="col-12 d-flex justify-content-between align">
										<button class="btn btn-outline-secondary btn-prev_ajusteStock" disabled>
											<i class="ri-arrow-left-line me-sm-1 me-0"></i>
											<span class="align-middle d-sm-inline-block d-none">Anterior</span>
										</button>
										<button class="btn btn-primary btn-next_ajusteStock">
											<span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
											<i class="ri-arrow-right-line"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div id="step2_ajusteStock" class="content">
						<div class="col-12 mb-6">
							<div class="row h-100 g-5">

								<div class="col-12 col-md-12 col-lg-6">
									<div class="card" style="min-height: 600px;">
										<h4 class="card-header fw-bold pb-0">Productos</h4>
										<div class="card-body">
											<p class="card-text">Selecciona un producto para ajustar su stock</p>
											<div class="row">

												<div class="col-12">
													<div class="input-group input-group-merge">
														<span class="input-group-text"><i class="ri-search-line"></i></span>
														<input
															type="text" class="form-control" placeholder="Buscar por nombre o SKU" />
													</div>
												</div>

												<div class="col-12 mt-5">
													<div class="table-responsive text-nowrap">
														<table class="table table-hover">

															<tbody id="tbodyListado_ajusteStock">

																<tr>
																	<td>
																		<div class="d-flex justify-content-between align-items-center">
																			<div class="d-flex justify-content-start align-items-center">
																				<div class="avatar-wrapper me-3">
																					<div class="avatar rounded-3 bg-label-secondary"><img src="../../assets/img/ecommerce-images/product-9.png" class="rounded-2"></div>
																				</div>
																				<div class="d-flex flex-column">
																					<span class="text-nowrap text-heading fw-medium">Pantalon</span>
																					<small class="text-truncate d-none d-sm-block">SKU: 1234ABCD</small>
																				</div>
																			</div>
																			<div>
																				<small class="text-truncate d-none d-sm-block">Stock: <b>120</b></small>

																			</div>
																		</div>

																	</td>
																</tr>

															</tbody>
														</table>
													</div>
												</div>

											</div>
										</div>
									</div>

								</div>

								<div class="col-12 col-md-12 col-lg-6">
									<div class="card" style="min-height: 600px;">

										<h4 class="card-header fw-bold pb-0">Movimiento de stock</h4>
										<div class="card-body">
											<p class="card-text">Agrega productos al listado de stock para procesarlos</p>
											<div class="row g-5">

												<div class="col-12 col-md-12 col-lg-12 border-top border-bottom mt-5 py-3">
													<div class="d-flex justify-content-between align-items-center">
														<div class="d-flex justify-content-start align-items-center">
															<div class="avatar-wrapper me-3">
																<div class="avatar rounded-3 bg-label-secondary"><img src="../../assets/img/ecommerce-images/product-9.png" class="rounded-2"></div>
															</div>
															<div class="d-flex flex-column">
																<span class="text-nowrap text-heading fw-medium">Pantalon</span>
																<small class="text-truncate d-none d-sm-block">SKU: 1234ABCD</small>
															</div>
														</div>
														<div>
															<small class="text-truncate d-none d-sm-block">Stock: <b>120</b></small>

														</div>
													</div>
												</div>

												<div class="col-12 col-md-12 col-lg-12">
													<div class="form-floating form-floating-outline">
														<select id="variante_ajusteStock" multiple class="form-select campos_ajusteStock camposObli_ajusteStock select2_ajusteStock"></select>
														<label for="variante_ajusteStock">Variante</label>
														<div class="invalid-feedback"> Debe seleccionar uno</div>
													</div>
												</div>

												<div class="col-12 col-md-12 col-lg-12">
													<div class="form-floating form-floating-outline">
														<input type="text" id="cantidad_ajusteStock" class="form-control campos_ajusteStock" placeholder="Cantidad" />
														<label for="cantidad_ajusteStock">Cantidad</label>
													</div>
												</div>

												<div class="col-12 col-md-12 col-lg-12">
													<div class="form-floating form-floating-outline">
														<input type="text" id="lote_ajusteStock" class="form-control campos_ajusteStock" placeholder="Lote" />
														<label for="lote_ajusteStock">Lote</label>
													</div>
												</div>

												<div class="col-12 col-md-12 col-lg-12">
													<div class="form-floating form-floating-outline">
														<input class="form-control campos_ajusteStock camposObli_ajusteStock" type="date" id="fechaVencimiento_ajusteStock" />
														<label for="fechaVencimiento_ajusteStock">Fecha de vencimiento</label>
														<div class="invalid-feedback"> Debe completar el campo </div>
													</div>
												</div>

												<div class="col-12">
													<div class="row justify-content-end">
														<div class="col-12 col-md-6 col-lg-3">
															<button class="btn btn-label-success w-100">
																<span class="align-middle d-sm-inline-block d-none me-sm-1">Agregar</span>
																<i class="ri-arrow-down-line"></i>
															</button>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>

								</div>

							</div>
						</div>

						<div class="col-12 mb-6">
							<div class="card">

								<h4 class="card-header fw-bold pb-0">Listado de movimientos de stock</h4>
								<div class="card-body">
									<p class="card-text">En este listado encontrara todas las modificaciones de stock que procesará</p>
									<div class="row g-5">

										<div class="col-12 col-md-12 col-lg-12 ">
											<div class="table-responsive text-nowrap ">
												<table class="table table-bordered">
													<thead class="table-thead">
														<tr>
															<th>Producto</th>
															<th>Combinacion</th>
															<th>Identificadores especiales</th>
															<th>Cantidad</th>
															<th>Desestimar</th>
														</tr>
													</thead>
													<tbody id="tbodyListaStock_ajusteStock">
														<tr>
															<td colspan="5">
																<div class="d-flex justify-content-center"><span class="badge rounded-pill bg-label-primary px-6">Sin stock nuevo</span></div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>

									</div>
								</div>
							</div>

						</div>

						<div class="card p-5">
							<div class="col-12">
								<div class="row h-100 align-items-end">
									<div class="col-12 d-flex justify-content-between align">
										<button class="btn btn-outline-secondary btn-prev_ajusteStock">
											<i class="ri-arrow-left-line me-sm-1 me-0"></i>
											<span class="align-middle d-sm-inline-block d-none">Anterior</span>
										</button>
										<button class="btn btn-success btn-submit_ajusteStock">
											<span class="align-middle d-sm-inline-block d-none me-sm-1">Subir stock</span>
											<i class="ri-arrow-right-line"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

					</div>

				</form>
			</div>
		</div>
	</div>


</div>
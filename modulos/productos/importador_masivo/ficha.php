<div class="winapp" id='ContainerImportadorMasivo' style="display:none;">

	<div class="card mb-6">
		<div class="card-body">
			<div class="d-flex align-items-center">
				<i class="ri-download-cloud-2-line ri-30px me-2"></i>
				<h3 class="mb-0">Importador masivo</h3>
			</div>
		</div>
	</div>

	<div class="col-12 mb-6">
		<div id="steps_importadorMasivo" class="bs-stepper wizard-numbered mt-2 linear">
			<div class="bs-stepper-header">
				<div class="step" data-target="#step1_importadorMasivo">
					<button type="button" class="step-trigger">
						<span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
						<span class="bs-stepper-label">
							<span class="bs-stepper-number">01</span>
							<span class="d-flex flex-column gap-1 ms-2">
								<span class="bs-stepper-title">Seleccionar cliente</span>
							</span>
						</span>
					</button>
				</div>
				<div class="line"></div>
				<div class="step" data-target="#step2_importadorMasivo">
					<button type="button" class="step-trigger">
						<span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
						<span class="bs-stepper-label">
							<span class="bs-stepper-number">02</span>
							<span class="d-flex flex-column gap-1 ms-2">
								<span class="bs-stepper-title">Seleccionar cuenta</span>
							</span>
						</span>
					</button>
				</div>
				<div class="line"></div>
				<div class="step" data-target="#step3_importadorMasivo">
					<button type="button" class="step-trigger">
						<span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
						<span class="bs-stepper-label">
							<span class="bs-stepper-number">03</span>
							<span class="d-flex flex-column gap-1 ms-2">
								<span class="bs-stepper-title">Seleccionar productos</span>
							</span>
						</span>
					</button>
				</div>
			</div>
			<div class="bs-stepper-content" style="min-height: 600px; max-height: 900px;">
				<form onSubmit="return false" class="h-100">

					<div id="step1_importadorMasivo" class="content" style="height: 600px;">
						<div class="col-12" style="height: 90%;">
							<div class="row h-100 justify-content-center align-items-center">
								<div class="col-12 col-md-12 col-lg-6">
									<div class="col-12 col-md-12 col-lg-12 text-center mb-5 d-flex justify-content-center">
										<span class="badge rounded-pill bg-label-warning text-wrap">Actualmente las tiendas disponibles para importar productos son Mercado Libre y Tienda Nube</span>
									</div>
									<div class="form-floating form-floating-outline">
										<select id="selectorCliente_importadorMasivo" class="form-select campos_importadorMasivo"></select>
										<label for="selectorCliente_importadorMasivo">Cliente</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12" style="height: 10%;">
							<div class="row h-100 align-items-end">
								<div class="col-12 d-flex justify-content-between align">
									<button class="btn btn-outline-secondary btn-prev_importadorMasivo" disabled>
										<i class="ri-arrow-left-line me-sm-1 me-0"></i>
										<span class="align-middle d-sm-inline-block d-none">Anterior</span>
									</button>
									<button class="btn btn-primary btn-next_importadorMasivo">
										<span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
										<i class="ri-arrow-right-line"></i>
									</button>
								</div>
							</div>
						</div>
					</div>

					<div id="step2_importadorMasivo" class="content" style="height: 600px;">
						<div class="col-12" style="height: 90%;">
							<div class="row h-100 justify-content-center align-items-center" style="overflow-y: auto;">
								<div class="col-12 col-md-8 col-lg-6 card-datatable table-responsive pt-0">
									<table class="datatables-basic table table-bordered">
										<thead>
											<tr>
												<th class="dt-checkboxes-cell dt-checkboxes-select-all" style="width: 18px;">
													<input class="form-check-input" id="checksAllTiendas_importadorMasivo" style="height: 18px; width: 18px;" type="checkbox" onchange="appImportadorMasivo.manejarSeleccionCuenta(this)" />
												</th>
												<th>Cuenta</th>
											</tr>
										</thead>
										<tbody id="bodyCuentas_importadorMasivo"></tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-12" style="height: 10%;">
							<div class="row h-100 align-items-end">
								<div class="col-12 d-flex justify-content-between align">
									<button class="btn btn-outline-secondary btn-prev_importadorMasivo">
										<i class="ri-arrow-left-line me-sm-1 me-0"></i>
										<span class="align-middle d-sm-inline-block d-none">Anterior</span>
									</button>
									<button class="btn btn-primary btn-next_importadorMasivo">
										<span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
										<i class="ri-arrow-right-line"></i>
									</button>
								</div>
							</div>
						</div>
					</div>

					<div id="step3_importadorMasivo" class="content ocultar" style="height: 900px;">
						<div class="col-12" id="containerCardsProductos_importadorMasivo"></div>
						<div class="col-12" style="height: 57px;">
							<div class="row h-100 align-items-end">
								<div class="col-12 d-flex justify-content-between align">
									<button class="btn btn-outline-secondary btn-prev_importadorMasivo">
										<i class="ri-arrow-left-line me-sm-1 me-0"></i>
										<span class="align-middle d-sm-inline-block d-none">Anterior</span>
									</button>
									<button class="btn btn-primary btn-submit_importadorMasivo">Seleccionar</button>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	<div id="lista_importadorMasivo" class="card ocultar">
		<div class="card-header border-bottom">

			<div class="row g-3 mb-5">
				<div class="col-12 col-md-6 col-lg-6 form-floating form-floating-outline">
					<input type="text" class="form-control campos_importadorMasivo inputs_importadorMasivo" id="filtroTitulo_importadorMasivo" placeholder="Titulo" onkeyup="appImportadorMasivo.filtrarLista()" />
					<label for="filtroTitulo_importadorMasivo">Buscar por titulo</label>
				</div>
				<div class="col-10 col-md-5 col-lg-5 form-floating form-floating-outline">
					<input type="text" class="form-control campos_importadorMasivo inputs_importadorMasivo" id="filtroSku_importadorMasivo" placeholder="SKU" onkeyup="appImportadorMasivo.filtrarLista()" />
					<label for="filtroSku_importadorMasivo">Buscar por SKU</label>
				</div>

				<div class="col-2 col-md-1 col-lg-1" style="align-items: center;display: flex;">
					<button type="button" class="btn btn-icon btn-warning waves-effect waves-light" onclick="appImportadorMasivo.limpiarCampos()">
						<span class="tf-icons ri-eraser-fill ri-22px"></span>
					</button>
				</div>

			</div>

		</div>

		<div class="table-responsive text-nowrap table-container">
			<table class="table table-hover">
				<thead class="table-thead">
					<tr>
						<th>Titulo</th>
						<th>SKU</th>
						<th>Precio</th>
						<th class="text-center">Desestimar</th>
					</tr>
				</thead>
				<tbody id="tbodyListado_importadorMasivo"></tbody>
			</table>
		</div>

		<div class="card-footer">
			<div class="col-12">
				<div class="row g-3 justify-content-end">
					<div class="col-12 col-md-6 col-lg-2">
						<button type="reset" class="btn btn-outline-danger w-100" onclick="appImportadorMasivo.resetModulo()">Cancelar</button>
					</div>
					<div class="col-12 col-md-6 col-lg-3">
						<button type="submit" class="btn btn-success w-100"><span class=" tf-icons ri-import-fill ri-19px me-2"></span>Importar productos</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<style>
	.cardsProductos_importadorMasivo {
		cursor: pointer;
		transition: transform 0.3s ease;
	}

	.cardsProductos_importadorMasivo:hover {
		transform: scale(1.05);
	}
</style>
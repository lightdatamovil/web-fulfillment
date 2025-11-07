<div class="modal fade" id="modal_mPedidoDeVentas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="d-flex position-absolute containerSvg" id="tienda_mPedidoDeVentas" style="top: 1.4rem;left: 1.4rem;width: 70px;height: auto;"></div>

			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mPedidoDeVentas">Pedido de venta</h4>
					<p class="mb-6" id="subtitulo_mPedidoDeVentas">Detalle del pedido de venta.</p>
				</div>

				<div class="col-12 my-3 border-top border-bottom">
					<div class="row py-5">

						<div class="col-12 col-md-4 col-lg-4">
							<ul class="list-unstyled m-0">
								<li class="d-flex align-items-center mb-4">
									<i class="ri-calendar-line ri-24px"></i><span class="mx-2">Fecha:</span>
									<span class="text-primary fw-bold" id="fecha_mPedidoDeVentas">Sin informacion</span>
								</li>
								<li class="d-flex align-items-center">
									<i class="ri-user-line ri-24px"></i><span class="mx-2">Cliente:</span>
									<span class="text-primary fw-bold" id="cliente_mPedidoDeVentas">Sin informacion</span>
								</li>
							</ul>
						</div>

						<div class="col-12 col-md-4 col-lg-4">
							<ul class="list-unstyled m-0">
								<li class="d-flex align-items-center mb-4">
									<i class="ri-box-3-line ri-24px"></i><span class="mx-2">Asignado a:</span>
									<span class="text-primary fw-bold" id="asignado_mPedidoDeVentas">Sin informacion</span>
								</li>
								<li class="d-flex align-items-center">
									<i class="ri-checkbox-line ri-24px"></i><span class="mx-2">Estado:</span>
									<span class="text-primary fw-bold" id="estado_mPedidoDeVentas">Sin informacion</span>
								</li>

							</ul>
						</div>

						<div class="col-12 col-md-4 col-lg-4">
							<ul class="list-unstyled m-0">
								<li class="d-flex align-items-center mb-4">
									<i class="ri-alarm-warning-line ri-24px"></i><span class="mx-2">Alertada:</span>
									<span class="text-primary fw-bold" id="alertada_mPedidoDeVentas">Sin informacion</span>
								</li>
								<li class="d-flex align-items-center">
									<i class="ri-hashtag ri-24px"></i><span class="mx-2">ID venta:</span>
									<span class="text-primary fw-bold" id="idVenta_mPedidoDeVentas">Sin informacion</span>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="nav-align-top col-12">
					<ul id="tabs_mPedidoDeVentas" class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<button
								type="button"
								class="nav-link active"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabProductos_mPedidoDeVentas"
								aria-controls="tabProductos_mPedidoDeVentas"
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
								data-bs-target="#tabInsumos_mPedidoDeVentas"
								aria-controls="tabInsumos_mPedidoDeVentas"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> Insumos</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0" style="height: 450px;">
					<div class="tab-pane fade show active" id="tabProductos_mPedidoDeVentas" role="tabpanel">

						<div class="table-responsive text-nowrap table-container" style="height: 400px;">
							<table class="table table-hover">
								<thead id="theadListaProductos_pedidoDeVentas" class="table-thead z-1">

									<tr>
										<th class="py-3">SKU</th>
										<th class="py-3">Producto</th>
										<th class="py-3">Combinacion</th>
										<th class="py-3 text-center">Cantidad</th>
									</tr>

								</thead>
								<tbody id="tbodyListaProductos_pedidoDeVentas"></tbody>
							</table>
						</div>

					</div>

					<div class="tab-pane fade" id="tabInsumos_mPedidoDeVentas" role="tabpanel">

						<div class="table-responsive text-nowrap table-container" style="height: 400px;">
							<table class="table table-hover">
								<thead id="theadListaInsumos_pedidoDeVentas" class="table-thead z-1">

									<tr>
										<th class="py-3">Insumo</th>
										<th class="py-3 text-center">Cantidad</th>
									</tr>

								</thead>
								<tbody id="tbodyListaInsumos_pedidoDeVentas">

								</tbody>
							</table>
						</div>

					</div>

				</div>

				<div class="col-12 border-top pt-5 mt-2">
					<div class="row justify-content-end g-3">

						<div class="col-12 col-md-6 col-lg-3">
							<button type="button" class="btn btn-label-warning btn-fab demo waves-effect w-100">
								<span class="tf-icons ri-delete-back-2-line ri-19px me-2"></span>Desestimar pedido
							</button>
						</div>

						<div class="col-12 col-md-6 col-lg-3">
							<button type="button" class="btn btn-label-dark btn-fab demo waves-effect w-100">
								<span class="tf-icons ri-printer-line ri-19px me-2"></span>Imprimir
							</button>
						</div>

						<div class="col-12 col-md-6 col-lg-4">
							<button type="button" class="btn btn-label-success btn-fab demo waves-effect w-100">
								<span class="tf-icons ri-check-double-line ri-19px me-2"></span>Marcar como armado
							</button>
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
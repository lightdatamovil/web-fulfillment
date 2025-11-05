<div class="modal fade" id="modal_mPedidoDeVentas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-6">
					<h4 class="mb-2" id="titulo_mPedidoDeVentas">Cliente</h4>
					<p class="mb-6" id="subtitulo_mPedidoDeVentas">Listado de pedidos de venta por cliente.</p>
				</div>
				<div class="nav-align-top col-12">
					<ul id="tabs_mPedidoDeVentas" class="nav nav-tabs nav-fill" role="tablist">
						<li class="nav-item">
							<button
								type="button"
								class="nav-link active"
								role="tab"
								data-bs-toggle="tab"
								data-bs-target="#tabGeneral_mPedidoDeVentas"
								aria-controls="tabGeneral_mPedidoDeVentas"
								aria-selected="true">
								<span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> Pedido de ventas</span>
								<i class="ri-survey-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="tabGeneral_mPedidoDeVentas" role="tabpanel">

						<div class="table-responsive text-nowrap table-container">
							<table class="table table-bordered">
								<thead class="table-thead z-1">
									<tr>
										<th class="py-4">Fecha</th>
										<th class="py-4">ID venta</th>
										<th class="py-4">Estado</th>
										<th class="py-4">Origen</th>
										<th class="py-4">Asgnado a</th>
										<th class="py-4">Seleccionar</th>
									</tr>
								</thead>
								<tbody id="listaPedidos_mPedidoDeVentas"></tbody>
							</table>
						</div>
					</div>

				</div>

				<div class="col-12 border-top pt-5 mt-2">
					<div class="row justify-content-end g-3">

						<div class="col-12 col-md-6 col-lg-3">
							<button type="button" class="btn btn-label-dark waves-effect w-100">
								<span class="tf-icons ri-file-excel-2-line ri-19px me-2"></span>Descargar Excel
							</button>
						</div>

						<div class="col-12 col-md-6 col-lg-3">
							<button type="button" class="btn btn-label-dark waves-effect w-100">
								<span class="tf-icons ri-printer-line ri-19px me-2"></span>Imprimir
							</button>
						</div>

						<div class="col-12 col-md-6 col-lg-4">
							<button type="button" class="btn btn-label-success waves-effect w-100">
								<span class="tf-icons ri-printer-line ri-19px me-2"></span>
								<span class="tf-icons ri-add-line ri-19px me-2"></span>
								<span class="tf-icons ri-box-3-line ri-19px me-2"></span>
								Imprimir + armado
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
<div class="modal fade" id="modalPedido" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg modal-simple">
		<div class="modal-content">

			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div id="tienda_mPedidos" class="d-flex position-absolute containerSvg" style="top: 1.4rem; left: 1.4rem; width: 60px; height: auto;"></div>
			<div class="modal-body p-0">
				<div class=" col-12 text-center mb-4">
					<p id="cliente_mPedidos" style="margin-bottom: 0.5rem;">cliente</p>
					<h4 class="mb-2 text-primary">N° de venta: <span id="numero_mPedidos" style="color: var(--bs-heading-color);"></span></h4>
					<h5 class="mb-2 text-primary">Comprador: <span id="comprador_mPedidos" style="color: var(--bs-heading-color);"></span></h5>
					<p id="fecha_mPedidos">00/00/0000 00:00</p>
					<div id="status_mPedidos" class="col-12 d-flex justify-content-center gap-1"></div>
				</div>
				<div class="nav-align-top col-12 mb-6">
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
								<span class="d-none d-sm-block"><i class="tf-icons ri-shopping-basket-2-line me-2"></i> Productos</span>
								<i class="ri-shopping-basket-2-line ri-20px d-sm-none"></i>
							</button>
						</li>
					</ul>
				</div>

				<div class="tab-content p-0">
					<div class="tab-pane fade show active" id="tabGeneral_mPedidos" role="tabpanel">
						<div id="items_mPedidos" style="overflow: auto;"></div>
					</div>
				</div>

				<div class="col-12 mt-7">
					<div class="row justify-content-end g-3">
						<div class="col-12 col-md-6 col-lg-2">
							<button type="reset" class="btn btn-outline-danger w-100 waves-effect" data-bs-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
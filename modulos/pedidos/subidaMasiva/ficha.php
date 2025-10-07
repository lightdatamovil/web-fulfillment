<div class="winapp" id='ContainerPedidosSubidaMasiva' style="display:none;">

	<div class="card mb-6">
		<div class="card-body">
			<div class="d-flex align-items-center">
				<i class="ri-file-upload-line ri-30px me-2"></i>
				<h3 class="mb-0">Subida masiva de pedidos</h3>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header border-bottom">

			<div class="row gx-3 gy-5 mb-3 align-items-center">

				<div class="col-12 col-md-6 col-lg-4">
					<div class="form-floating form-floating-outline">
						<select id="filtroCliente_pedidosSubidaMasiva" class="form-select campos_pedidosSubidaMasiva"></select>
						<label for="filtroCliente_pedidosSubidaMasiva">Cliente</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-4">
					<input type="file" id="archivo_pedidosSubidaMasiva" class="d-none" onchange="appPedidosSubidaMasiva.subirExcel()" />
					<label for="archivo_pedidosSubidaMasiva" class="btn btn-label-success w-100" style="cursor: pointer;">
						<span class="tf-icons ri-file-excel-2-fill ri-19px me-2"></span>Seleccionar Excel
					</label>
				</div>

				<div class="col-12 col-md-6 col-lg-4">
					<button class="btn btn-label-warning w-100" onclick="appPedidosSubidaMasiva.descargarModelo()"><span class=" tf-icons ri-file-download-fill ri-19px me-2"></span>Descargar modelo</button>
				</div>
			</div>

			<div class="row g-3 mb-3 align-items-center">
			</div>

		</div>


		<div class="card-body" id="instrucciones_pedidosSubidaMasiva">

			<div class="row align-itmes-center" style="min-height: 585px;">
				<div class="col-12 col-md-6 col-lg-3 d-flex gap-5 flex-column justify-content-center text-center my-5 my-md-0">
					<i class="ri-file-download-line" style="font-size: 50px;"></i>
					<div>
						<p class="fw-bold m-0" style="font-size: 20px;">Paso 1:</p>
						<p class="m-0" style="font-size: 20px;">Descargar modelo</p>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-3 d-flex gap-5 flex-column justify-content-center text-center my-5 my-md-0">
					<i class="ri-user-line" style="font-size: 50px;"></i>
					<div>
						<p class="fw-bold m-0" style="font-size: 20px;">Paso 2:</p>
						<p class="m-0" style="font-size: 20px;">Seleccionar cliente</p>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-3 d-flex gap-5 flex-column justify-content-center text-center my-5 my-md-0">
					<i class="ri-file-excel-2-line" style="font-size: 50px;"></i>
					<div>
						<p class="fw-bold m-0" style="font-size: 20px;">Paso 3:</p>
						<p class="m-0" style="font-size: 20px;">Seleccionar Excel</p>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-3 d-flex gap-5 flex-column justify-content-center text-center my-5 my-md-0">
					<i class="ri-upload-cloud-line" style="font-size: 50px;"></i>
					<div>
						<p class="fw-bold m-0" style="font-size: 20px;">Paso 4:</p>
						<p class="m-0" style="font-size: 20px;">Subir pedidos</p>
					</div>
				</div>

			</div>

		</div>

		<div id="containerTable_pedidosSubidaMasiva"></div>

	</div>
</div>
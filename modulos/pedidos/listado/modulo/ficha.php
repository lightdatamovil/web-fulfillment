<div class="winapp" id='modulo_pedidos' style="display:none;">

	<div class="card mb-6">
		<div class="card-body">
			<div class="d-flex align-items-center">
				<i class="ri-checkbox-circle-line ri-30px me-2"></i>
				<h3 class="mb-0">Pedidos</h3>
			</div>
		</div>
	</div>

	<div class="card">

		<div class="card-header border-bottom">

			<div class="row gy-5 gx-3 mb-5">

				<div class="col-12 col-md-6 col-lg-3">
					<div class="input-group input-daterange">
						<input type="date" class="form-control campos_pedidos" id="filtroFechaDesde_pedidos" />
						<span class="input-group-text cursor-pointer" id="tipoFecha_pedidos" onclick="appModuloPedidos.cambiarTipoFecha()"><i class="ri-arrow-right-s-line"></i></span>
						<input type="date" class="form-control campos_pedidos" id="filtroFechaHasta_pedidos" />
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<input type="text" class="form-control campos_pedidos inputs_pedidos" id="filtroIdVenta_pedidos" placeholder="ID Venta" />
						<label for="filtroIdVenta_pedidos">Buscar por ID venta</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<input type="text" class="form-control campos_pedidos inputs_pedidos" id="filtroComprador_pedidos" placeholder="Comprador" />
						<label for="filtroComprador_pedidos">Buscar por comprador</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroArmado_pedidos" class="form-select campos_pedidos">
							<option value="" selected>Todos</option>
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
						<label for="filtroArmado_pedidos">Armado</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroTrabajado_pedidos" class="form-select campos_pedidos">
							<option value="" selected>Todos</option>
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
						<label for="filtroTrabajado_pedidos">Trabajado</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroClientes_pedidos" multiple class="form-select campos_pedidos select2_pedidos"></select>
						<label for="filtroClientes_pedidos">Clientes</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroOrigen_pedidos" multiple class="form-select campos_pedidos select2_pedidos"></select>
						<label for="filtroOrigen_pedidos">Origen</label>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroEstado_pedidos" multiple class="form-select campos_pedidos select2_pedidos"></select>
						<label for="filtroEstado_pedidos">Estado</label>
					</div>
				</div>

			</div>

			<div class="row g-3 mb-3">
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-label-success w-100" onclick="appModalPedidos.open()"><span class="tf-icons ri-box-3-fill ri-19px me-2"></span>Nuevo</button>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-warning w-100" onclick="appModuloPedidos.limpiarCampos()">Limpiar filtros</button>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-primary w-100" onclick="appModuloPedidos.getListado({type: 1})">Filtrar</button>
				</div>
			</div>

		</div>

		<div class="table-responsive text-nowrap table-container">
			<table class="table table-hover">
				<thead id="theadListado_pedidos" class="table-thead">
					<tr>
						<th data-order="did_cliente">Cliente</th>
						<th data-order="fecha">Fecha</th>
						<th data-order="flex">Origen</th>
						<th data-order="id_venta">ID Venta</th>
						<!-- <th data-order="comprador">Comprador</th> -->
						<th data-order="estado">Estado</th>
						<!-- <th data-order="total">Total</th> -->
						<th class="text-center" data-order="armado">Armado</th>
						<th class="text-center" data-order="trabajado">Trabajar</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="tbodyListado_pedidos"></tbody>
			</table>
		</div>

		<div class="card-footer" id="footer_pedidos"></div>

	</div>
</div>
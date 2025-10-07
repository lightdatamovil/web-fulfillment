<div class="winapp" id='ContainerPedidosListado' style="display:none;">

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

			<div class="row gx-3 gy-5 mb-5">
				<div class="col-12 col-md-6 col-lg-4">
					<div class="form-floating form-floating-outline">
						<select id="filtroCliente_pedidos" class="form-select campos_pedidos"></select>
						<label for="filtroCliente_pedidos">Cliente</label>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-4 form-floating form-floating-outline">
					<input type="text" class="form-control campos_pedidos inputs_pedidos" id="filtroIdVenta_pedidos" placeholder="ID venta" />
					<label for="filtroIdVenta_pedidos">Buscar por ID venta</label>
				</div>
				<div class="col-12 col-md-6 col-lg-4 form-floating form-floating-outline">
					<input type="text" class="form-control campos_pedidos inputs_pedidos" id="filtroComprador_pedidos" placeholder="Comprador" />
					<label for="filtroComprador_pedidos">Buscar por comprador</label>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroEstado_pedidos" class="form-select campos_pedidos"></select>
						<label for="filtroEstado_pedidos">Estado</label>
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
						<select id="filtroOrigen_pedidos" class="form-select campos_pedidos"></select>
						<label for="filtroOrigen_pedidos">Origen</label>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-3 form-floating form-floating-outline">
					<input type="text" class="form-control campos_pedidos inputs_pedidos" id="filtroOT_pedidos" placeholder="OT" />
					<label for="filtroOT_pedidos">Buscar por OT</label>
				</div>
			</div>

			<div class="row g-3 mb-3 align-items-center">
				<!-- <div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-label-success w-100" onclick="appPedido.open(0, 0)"><span class=" tf-icons ri-user-add-fill ri-19px me-2"></span>Nuevo</button>
				</div> -->
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-warning w-100" onclick="appPedidosListado.limpiarCampos()">Limpiar filtros</button>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-primary w-100" onclick="appPedidosListado.getListado(1)">Filtrar</button>
				</div>
			</div>

		</div>

		<div class="table-responsive text-nowrap table-container">
			<table class="table table-hover">
				<thead class="table-thead">
					<tr>
						<th>Cliente</th>
						<th>Fecha</th>
						<th>Origen</th>
						<th>#Venta</th>
						<th>Comprador</th>
						<th>Estado</th>
						<th>Total</th>
						<th>Armado</th>
						<th>OT</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="tbodyListado_pedidos"></tbody>
			</table>
		</div>

		<div class="card-footer" id="footer_pedidos"></div>

	</div>
</div>
<div class="winapp" id='modulo_usuarios' style="display:none;">

	<div class="card mb-6">
		<div class="card-body">
			<div class="d-flex align-items-center">
				<i class="ri-user-3-line ri-30px me-2"></i>
				<h3 class="mb-0">Usuarios</h3>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header border-bottom">

			<div class="row g-3 mb-5">
				<div class="col-12 col-md-12 col-lg-2">
					<div class=" form-floating form-floating-outline">
						<input type="text" class="form-control campos_usuarios inputs_usuarios" id="filtroUsuario_usuarios" placeholder="Usuario" />
						<label for="filtroUsuario_usuarios">Buscar por usuario</label>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-2">
					<div class="form-floating form-floating-outline">
						<input type="text" class="form-control campos_usuarios inputs_usuarios" id="filtroNombre_usuarios" placeholder="Nombre" />
						<label for="filtroNombre_usuarios">Buscar por nombre</label>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-2">
					<div class="form-floating form-floating-outline">
						<input type="text" class="form-control campos_usuarios inputs_usuarios" id="filtroApellido_usuarios" placeholder="Apellido" />
						<label for="filtroApellido_usuarios">Buscar por apellido</label>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroPerfil_usuarios" class="select2_usuarios form-select campos_usuarios" multiple></select>
						<label for="filtroPerfil_usuarios">Buscar por perfil</label>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<div class="form-floating form-floating-outline">
						<select id="filtroEstado_usuarios" class="form-select campos_usuarios">
							<option value="" selected>Todos</option>
							<option value="1">Habilitado</option>
							<option value="0">Deshabilitado</option>
						</select>
						<label for="filtroEstado_usuarios">Buscar por estado</label>
					</div>
				</div>
			</div>

			<div class="row g-3 mb-3">
				<div class="col-12 col-md-12 col-lg-3">
					<button class="btn btn-label-success w-100" onclick="appModalUsuarios.open()"><span class=" tf-icons ri-user-add-fill ri-19px me-2"></span>Nuevo</button>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-warning w-100" onclick="appModuloUsuarios.limpiarCampos()">Limpiar filtros</button>
				</div>
				<div class="col-12 col-md-6 col-lg-3">
					<button class="btn btn-primary w-100" onclick="appModuloUsuarios.getListado({type: 1})">Filtrar</button>
				</div>
			</div>

		</div>

		<div class="table-responsive text-nowrap table-container">
			<table class="table table-hover">
				<thead id="theadListado_usuarios" class="table-thead">
					<tr>
						<th data-order="usuario">Usuario</th>
						<th data-order="nombre">Nombre</th>
						<th data-order="apellido">Apellido</th>
						<th data-order="email">Email</th>
						<th data-order="perfil">Perfil</th>
						<th data-order="habilitado">Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="tbodyListado_usuarios"></tbody>
			</table>
		</div>

		<div class="card-footer" id="footer_usuarios"></div>

	</div>
</div>
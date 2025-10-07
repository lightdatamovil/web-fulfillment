<div class="winapp" id='modulo_clientes' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-user-3-line ri-30px me-2"></i>
                <h3 class="mb-0">Clientes</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row g-3 mb-5">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control inputs_clientes" id="filtroCodigo_clientes" placeholder="Codigo" />
                        <label for="filtroCodigo_clientes">Buscar por codigo</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control inputs_clientes" id="filtroNombreFantasia_clientes" placeholder="Nombre fantasia" />
                        <label for="filtroNombreFantasia_clientes">Buscar por nombre fantasia</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control inputs_clientes" id="filtroRazonSocial_clientes" placeholder="Razon social" />
                        <label for="filtroRazonSocial_clientes">Buscar por razon social</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_clientes" class="form-select campos_clientes">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroEstado_clientes">Buscar por estado</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-12 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalClientes.open()"><span class=" tf-icons ri-user-add-fill ri-19px me-2"></span>Nuevo</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloClientes.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloClientes.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_clientes" class="table-thead">
                    <tr>
                        <th data-order="codigo">Código</th>
                        <th data-order="nombre_fantasia">Nombre Fantasía</th>
                        <th data-order="razon_social">Razón Social</th>
                        <th data-order="habilitado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_clientes"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_clientes"></div>

    </div>
</div>
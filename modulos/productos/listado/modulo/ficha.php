<div class="winapp" id='modulo_productos' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-shopping-bag-3-line ri-30px me-2"></i>
                <h3 class="mb-0">Productos</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row g-3 mb-5">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroClientes_productos" multiple class="form-select campos_productos select2_productos"></select>
                        <label for="filtroClientes_productos">Clientes</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_productos inputs_productos" id="filtroTitulo_productos" placeholder="Titulo" />
                        <label for="filtroTitulo_productos">Buscar por titulo</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_productos inputs_productos" id="filtroSku_productos" placeholder="SKU" />
                        <label for="filtroSku_productos">Buscar por SKU</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_productos" class="form-select campos_productos">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroEstado_productos">Estado</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalProductos.open()"><span class="tf-icons ri-box-3-fill ri-19px me-2"></span>Nuevo</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloProductos.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloProductos.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_productos" class="table-thead">
                    <tr>
                        <th data-order="cliente">Cliente</th>
                        <th data-order="titulo">Titulo</th>
                        <th data-order="sku">SKU</th>
                        <th data-order="habilitado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_productos"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_productos"></div>

    </div>
</div>
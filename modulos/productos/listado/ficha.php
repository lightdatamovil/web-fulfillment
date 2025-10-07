<div class="winapp" id='ContainerProductosListado' style="display:none;">

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
                <div class="col-12 col-md-6 col-lg-4 form-floating form-floating-outline">
                    <input type="text" class="form-control inputs_productos" id="filtroSku_productos" placeholder="SKU" />
                    <label for="filtroSku_productos">Buscar por SKU</label>
                </div>
                <div class="col-12 col-md-6 col-lg-4 form-floating form-floating-outline">
                    <input type="text" class="form-control inputs_productos" id="filtroTitulo_productos" placeholder="Titulo" />
                    <label for="filtroTitulo_productos">Buscar por titulo</label>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroClientes_productos" class="form-select"></select>
                        <label for="filtroClientes_productos">Clientes</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appProducto.open(0, 0)"><span class=" tf-icons ri-shopping-basket-2-fill ri-19px me-2"></span>Nuevo</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appProductosListado.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appProductosListado.getListado(1)">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead class="table-thead">
                    <tr>
                        <th>Cliente</th>
                        <th>Título</th>
                        <th>SKU</th>
                        <th>EAN</th>
                        <th>Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_productos"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_productos"></div>

    </div>
</div>
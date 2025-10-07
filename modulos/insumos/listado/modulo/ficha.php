<div class="winapp" id='modulo_insumos' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-box-3-line ri-30px me-2"></i>
                <h3 class="mb-0">Insumos</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row g-3 mb-5">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_insumos inputs_insumos" id="filtroCodigo_insumos" placeholder="Codigo" />
                        <label for="filtroCodigo_insumos">Buscar por codigo</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_insumos inputs_insumos" id="filtroNombre_insumos" placeholder="Nombre" />
                        <label for="filtroNombre_insumos">Buscar por nombre</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_insumos" class="form-select campos_insumos">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroEstado_insumos">Estado</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalInsumos.open()"><span class="tf-icons ri-box-3-fill ri-19px me-2"></span>Nuevo</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloInsumos.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloInsumos.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_insumos" class="table-thead">
                    <tr>
                        <th data-order="codigo">Codigo</th>
                        <th data-order="nombre">Nombre</th>
                        <th data-order="habilitado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_insumos"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_insumos"></div>

    </div>
</div>
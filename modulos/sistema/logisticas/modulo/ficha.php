<div class="winapp" id='modulo_logisticas' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-truck-line ri-30px me-2"></i>
                <h3 class="mb-0">Logisticas</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row g-3 mb-5">
                <div class="col-12 col-md-6 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_logisticas inputs_logisticas" id="filtroCodigo_logisticas" placeholder="Codigo" />
                        <label for="filtroCodigo_logisticas">Buscar por codigo</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_logisticas inputs_logisticas" id="filtroNombre_logisticas" placeholder="Nombre" />
                        <label for="filtroNombre_logisticas">Buscar por nombre</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroSync_logisticas" multiple class="form-select campos_logisticas select2_logisticas"></select>
                        <label for="filtroSync_logisticas">Tipo de logistica</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_logisticas inputs_logisticas" id="filtroCodigoSync_logisticas" placeholder="Codigo de logistica" />
                        <label for="filtroCodigoSync_logisticas">Buscar por codigo de logistica</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_logisticas" class="form-select campos_logisticas select_logisticas">
                            <option value="todos" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroEstado_logisticas">Estado</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalLogisticas.open()"><span class="tf-icons ri-truck-fill ri-19px me-2"></span>Nueva</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloLogisticas.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloLogisticas.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_logisticas" class="table-thead">
                    <tr>
                        <th data-order="codigo">Codigo</th>
                        <th data-order="nombre">Nombre</th>
                        <th data-order="sync">Tipo de logistica</th>
                        <th data-order="codigoSync">Codigo de logistica</th>
                        <th data-order="habilitado">Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_logisticas"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_logisticas"></div>

    </div>
</div>
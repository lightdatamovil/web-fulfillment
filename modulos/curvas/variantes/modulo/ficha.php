<div class="winapp" id='modulo_variantes' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-palette-line ri-30px me-2"></i>
                <h3 class="mb-0">Variantes de producto</h3>
            </div>

        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row g-3 mb-5">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control inputs_variantes campos_variantes" id="filtroCodigo_variantes" placeholder="Codigo" />
                        <label for="filtroCodigo_variantes">Buscar por codigo</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control inputs_variantes campos_variantes" id="filtroNombre_variantes" placeholder="Nombre" />
                        <label for="filtroNombre_variantes">Buscar por nombre</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_variantes" class="form-select campos_variantes">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroEstado_variantes">Estado</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalVariantes.open()"><span class="tf-icons ri-function-add-fill ri-19px me-2"></span>Nueva</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloVariantes.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloVariantes.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_variantes" class="table-thead">
                    <tr>
                        <th data-order="codigo">Codigo</th>
                        <th data-order="nombre">Nombre</th>
                        <th data-order="habilitado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_variantes"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_variantes"></div>

    </div>
</div>
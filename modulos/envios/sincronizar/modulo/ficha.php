<div class="winapp" id='modulo_enviosSincronizar' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-box-3-line ri-30px me-2"></i>
                <h3 class="mb-0">Sincronizacion de envios</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body border-bottom py-7">
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroCliente_enviosSincronizar" class="form-select campos_enviosSincronizar"></select>
                        <label for="filtroCliente_enviosSincronizar">Cliente</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_enviosSincronizar inputs_enviosSincronizar" id="filtroIdVenta_enviosSincronizar" placeholder="ID Venta" />
                        <label for="filtroIdVenta_enviosSincronizar">Buscar por ID Venta</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_enviosSincronizar inputs_enviosSincronizar" id="filtroComprador_enviosSincronizar" placeholder="Comprador" />
                        <label for="filtroComprador_enviosSincronizar">Buscar por Comprador</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_enviosSincronizar" class="form-select campos_enviosSincronizar">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroEstado_enviosSincronizar">Estado</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroArmado_enviosSincronizar" class="form-select campos_enviosSincronizar">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroArmado_enviosSincronizar">Armado</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroOrigen_enviosSincronizar" class="form-select campos_enviosSincronizar">
                            <option value="" selected>Todos</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                        </select>
                        <label for="filtroOrigen_enviosSincronizar">Origen</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_enviosSincronizar inputs_enviosSincronizar" id="filtroOT_enviosSincronizar" placeholder="OT" />
                        <label for="filtroOT_enviosSincronizar">Buscar por OT</label>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-warning w-100" onclick="appModuloEnviosSincronizar.limpiarCampos()">Limpiar filtros</button>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-primary w-100" onclick="appModuloEnviosSincronizar.getListado({type: 1})">Filtrar</button>
                </div>
            </div>

        </div>

        <div class="card-body border-bottom mt-3">
            <div class="row g-3 mb-3 align-items-baseline">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="logistica_enviosSincronizar" class="form-select campos_enviosSincronizar">
                            <option value="" selected disabled>Seleccionar logistica</option>
                            <option value="1">Logis1</option>
                            <option value="2">Logis2</option>
                        </select>
                        <label for="logistica_enviosSincronizar">Logistica</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <button class="btn btn-label-success w-100" onclick="appModalEnviosSincronizar.open()"><span class="tf-icons ri-corner-down-right-line ri-19px me-2"></span>Procesar</button>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_enviosSincronizar" class="table-thead">
                    <tr>
                        <th data-order="cliente">Cliente</th>
                        <th data-order="fecha">Fecha</th>
                        <th data-order="origen">Origen</th>
                        <th data-order="id_venta">ID Venta</th>
                        <th data-order="comprador">Comprador</th>
                        <th data-order="estado">Estado</th>
                        <th data-order="total">Total</th>
                        <th data-order="armado">Armado</th>
                        <th data-order="ot">OT</th>
                        <th>Ver</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_enviosSincronizar"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_enviosSincronizar"></div>

    </div>
</div>